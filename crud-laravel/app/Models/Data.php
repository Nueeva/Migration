<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    // Mendefinisikan nama tabel secara eksplisit karena nama tabel 'data' (bukan jamak bahasa Inggris)
    protected $table = 'data'; 

    // Kolom yang diizinkan untuk diisi (Mass Assignment)
    protected $fillable = [
        'nik',
        'nama',
        'telepon',
        'alamat'
    ];
}