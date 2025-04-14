<?php

namespace App\Http\Controllers;

use App\Models\penjualan;
use App\Models\product;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('staff.sales.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = product::get();
        return view('staff.sales.create', compact('products'));
    }

    public function checkout(Request $request)
    {
        $produkDipilih = $request->input('produk', []);
        $produkDenganQty = [];
        foreach ($produkDipilih as $id => $qty) {
            if ((int) $qty > 0) {
                $produk = product::find($id);
                if ($produk) {
                    $produk->jumlah_dipilih = (int) $qty;
                    $produkDenganQty[] = $produk;
                }
            }
        }
        return view('staff.sales.checkout', compact('produkDenganQty'));
    }


    /**
     * Display the specified resource.
     */
    public function show(penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(penjualan $penjualan)
    {
        //
    }
}
