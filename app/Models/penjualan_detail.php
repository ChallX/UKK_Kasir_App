<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penjualan_detail extends Model
{
    protected $guarded = [];

    public function product () {
        return $this->belongsTo(product::class);
    }

    public function penjualan () {
        return $this->belongsTo(penjualan::class);
    }
}
