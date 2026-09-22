<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'kode_barang' => 'COMP-001',
                'nama_barang' => 'NVIDIA GeForce RTX 4090 24GB GDDR6X',
                'kategori'    => 'VGA Card',
                'harga'       => 32500000,
                'stok'        => 8,
                'gambar'      => 'https://images.unsplash.com/photo-1591488320449-011701bb6704?w=500&auto=format&fit=crop',
            ],
            [
                'kode_barang' => 'COMP-002',
                'nama_barang' => 'Intel Core i9-14900K 24-Cores 32-Threads',
                'kategori'    => 'Processor',
                'harga'       => 9800000,
                'stok'        => 12,
                'gambar'      => 'https://images.unsplash.com/photo-1555680202-c86f0e12f086?w=500&auto=format&fit=crop',
            ],
            [
                'kode_barang' => 'COMP-003',
                'nama_barang' => 'ASUS ROG Swift OLED 27" 240Hz Gaming Monitor',
                'kategori'    => 'Monitor',
                'harga'       => 14250000,
                'stok'        => 5,
                'gambar'      => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=500&auto=format&fit=crop',
            ],
            [
                'kode_barang' => 'COMP-004',
                'nama_barang' => 'Corsair Vengeance DDR5 32GB (2x16GB) 6000MHz RGB',
                'kategori'    => 'RAM',
                'harga'       => 2450000,
                'stok'        => 25,
                'gambar'      => 'https://images.unsplash.com/photo-1562976540-1502c2145186?w=500&auto=format&fit=crop',
            ],
            [
                'kode_barang' => 'COMP-005',
                'nama_barang' => 'Samsung 990 PRO 2TB PCIe 4.0 NVMe SSD',
                'kategori'    => 'Storage',
                'harga'       => 2950000,
                'stok'        => 30,
                'gambar'      => 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=500&auto=format&fit=crop',
            ],
            [
                'kode_barang' => 'COMP-006',
                'nama_barang' => 'Logitech G PRO X Superlight 2 Wireless Gaming Mouse',
                'kategori'    => 'Peripheral',
                'harga'       => 2250000,
                'stok'        => 18,
                'gambar'      => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=500&auto=format&fit=crop',
            ],
            [
                'kode_barang' => 'COMP-007',
                'nama_barang' => 'Keychron Q1 Pro Custom Mechanical Keyboard RGB',
                'kategori'    => 'Peripheral',
                'harga'       => 3100000,
                'stok'        => 15,
                'gambar'      => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=500&auto=format&fit=crop',
            ],
            [
                'kode_barang' => 'COMP-008',
                'nama_barang' => 'SteelSeries Arctis Nova Pro Wireless Headset',
                'kategori'    => 'Peripheral',
                'harga'       => 5400000,
                'stok'        => 14,
                'gambar'      => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=500&auto=format&fit=crop',
            ],
            [
                'kode_barang' => 'COMP-009',
                'nama_barang' => 'ASUS ROG Thor 1200W Platinum II Fully Modular PSU',
                'kategori'    => 'Power Supply',
                'harga'       => 4750000,
                'stok'        => 10,
                'gambar'      => 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?w=500&auto=format&fit=crop',
            ],
            [
                'kode_barang' => 'COMP-010',
                'nama_barang' => 'Lian Li O11 Dynamic EVO XL Full Tower Chassis',
                'kategori'    => 'Casing',
                'harga'       => 3850000,
                'stok'        => 7,
                'gambar'      => 'https://images.unsplash.com/photo-1587202372634-32705e3bf49c?w=500&auto=format&fit=crop',
            ],
        ];

        foreach ($products as $prod) {
            Barang::updateOrCreate(
                ['kode_barang' => $prod['kode_barang']],
                $prod
            );
        }
    }
}
