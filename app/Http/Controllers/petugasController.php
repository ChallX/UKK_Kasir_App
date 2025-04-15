<?php

namespace App\Http\Controllers;

use App\Models\penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class petugasController extends Controller
{
    public function index() {
        $penjualan = Penjualan::whereDate('created_at', Carbon::now())->count();
        $date = Penjualan::latest()->first();
        return view("staff.index", compact('penjualan', 'date'));
    }
}
