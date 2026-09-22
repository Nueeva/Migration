<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['no_nota', 'total_harga', 'diskon', 'bayar', 'kembali'];

    public function items()
    {
        return $this->hasMany(TransaksiItem::class);
    }
}

