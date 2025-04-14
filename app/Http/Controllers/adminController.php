<?php

namespace App\Http\Controllers;

use App\Models\penjualan;
use App\Models\penjualan_detail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminController extends Controller
{
    public function index()
    {

        $penjualanPerHariSelama1Bulan = DB::table('penjualans')
            ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('tanggal')
            ->get();


        $persentasePenjualanProduk = DB::table('penjualan_details')
            ->join('products', 'penjualan_details.product_id', '=', 'products.id')
            ->select('products.nama_product', DB::raw('SUM(penjualan_details.qty) as total'))
            ->groupBy('products.nama_product')
            ->get();


        return view('admin.index', compact('penjualanPerHariSelama1Bulan', 'persentasePenjualanProduk'));
    }
}
