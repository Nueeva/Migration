<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // Nama tabel di database (sesuaikan jika di phpMyAdmin namanya 'barangs' atau 'barang')
    protected $table = 'barangs'; 

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'harga',
        'stok',
        'gambar',
    ];

    protected $appends = ['gambar_url'];

    public function getGambarUrlAttribute(): ?string
    {
        if (!$this->gambar) {
            return null;
        }

        if (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://')) {
            return $this->gambar;
        }

        return asset('storage/' . $this->gambar);
    }
}
