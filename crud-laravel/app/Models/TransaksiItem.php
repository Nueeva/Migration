<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    protected $fillable = ['transaksi_id', 'nama_barang', 'harga', 'qty', 'subtotal'];
}
