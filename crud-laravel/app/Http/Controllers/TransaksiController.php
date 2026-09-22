<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with('items');

        if ($request->has('search') && $request->search !== '') {
            $query->where('no_nota', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->start_date, $request->end_date]);
        } elseif ($request->filled('period')) {
            if ($request->period === 'today') {
                $query->whereDate('created_at', date('Y-m-d'));
            } elseif ($request->period === '7days') {
                $query->where('created_at', '>=', now()->subDays(7));
            } elseif ($request->period === 'month') {
                $query->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'));
            }
        }

        $transaksi = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($transaksi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'bayar'  => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'items'  => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $subtotalBelanja = 0;
                $itemsData = [];

                foreach ($request->items as $item) {
                    $barang = Barang::where('id', $item['id'])->lockForUpdate()->first();
                    if (!$barang) {
                        throw new Exception("Barang tidak ditemukan.");
                    }
                    if ($barang->stok < $item['qty']) {
                        throw new Exception("Stok {$barang->nama_barang} tidak mencukupi!");
                    }

                    $subtotal = $barang->harga * $item['qty'];
                    $subtotalBelanja += $subtotal;
                    $barang->decrement('stok', $item['qty']);

                    $itemsData[] = [
                        'nama_barang' => $barang->nama_barang,
                        'harga'       => $barang->harga,
                        'qty'         => $item['qty'],
                        'subtotal'    => $subtotal,
                    ];
                }

                $diskon = max(0, (int) ($request->diskon ?? 0));
                $totalHarga = max(0, $subtotalBelanja - $diskon);

                if ($request->bayar < $totalHarga) {
                    throw new Exception('Uang pembayaran kurang!');
                }

                $transaksi = Transaksi::create([
                    'no_nota'     => 'TRX-' . time(),
                    'total_harga' => $totalHarga,
                    'diskon'      => $diskon,
                    'bayar'       => $request->bayar,
                    'kembali'     => $request->bayar - $totalHarga,
                ]);

                foreach ($itemsData as $item) {
                    $transaksi->items()->create($item);
                }

                return response()->json([
                    'status'    => 'success',
                    'transaksi' => $transaksi->load('items'),
                ], 201);
            });
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function dashboardStats()
    {
        $totalOmset = Transaksi::sum('total_harga');
        $totalTransaksi = Transaksi::count();
        
        $today = date('Y-m-d');
        $omsetHariIni = Transaksi::whereDate('created_at', $today)->sum('total_harga');
        $transaksiHariIni = Transaksi::whereDate('created_at', $today)->count();

        $totalProduk = Barang::count();
        $stokMenipisCount = Barang::where('stok', '>', 0)->where('stok', '<=', 3)->count();
        $stokHabisCount = Barang::where('stok', 0)->count();

        $transaksiTerbaru = Transaksi::with('items')->orderBy('created_at', 'desc')->take(5)->get();

        $produkTerlaris = TransaksiItem::select('nama_barang', DB::raw('SUM(qty) as total_terjual'), DB::raw('SUM(subtotal) as total_pendapatan'))
            ->groupBy('nama_barang')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        // 7-day Daily Omset Trend
        $dailyOmset = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = date('Y-m-d', strtotime("-$i days"));
            $omset = Transaksi::whereDate('created_at', $d)->sum('total_harga');
            $count = Transaksi::whereDate('created_at', $d)->count();
            $dailyOmset[] = [
                'date'  => date('d M', strtotime($d)),
                'omset' => (int) $omset,
                'count' => (int) $count,
            ];
        }

        // Category Revenue Distribution
        $categoryRevenue = DB::table('transaksi_items')
            ->join('barangs', 'transaksi_items.nama_barang', '=', 'barangs.nama_barang')
            ->select('barangs.kategori', DB::raw('SUM(transaksi_items.subtotal) as total_revenue'), DB::raw('SUM(transaksi_items.qty) as total_qty'))
            ->groupBy('barangs.kategori')
            ->orderByDesc('total_revenue')
            ->get();

        return response()->json([
            'total_omset'        => $totalOmset ?: 0,
            'total_transaksi'    => $totalTransaksi ?: 0,
            'omset_hari_ini'     => $omsetHariIni ?: 0,
            'transaksi_hari_ini' => $transaksiHariIni ?: 0,
            'total_produk'       => $totalProduk ?: 0,
            'stok_menipis_count' => $stokMenipisCount ?: 0,
            'stok_habis_count'   => $stokHabisCount ?: 0,
            'transaksi_terbaru'  => $transaksiTerbaru,
            'produk_terlaris'    => $produkTerlaris,
            'daily_omset'        => $dailyOmset,
            'category_revenue'   => $categoryRevenue,
        ]);
    }
}

