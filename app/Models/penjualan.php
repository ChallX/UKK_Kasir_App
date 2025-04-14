<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penjualan extends Model
{
    protected $guarded = [];

    public function member() {
        return $this->belongsTo(member::class);
    }

    public function penjualanDetails() {
        return $this->hasMany(penjualan_detail::class);
    }

    public function user () {
        return $this->belongsTo(user::class);
    }
}
