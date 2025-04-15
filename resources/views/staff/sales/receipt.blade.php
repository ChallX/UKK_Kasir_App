@extends('layouts.dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-10">Penjualan</h1>

    <div class="border w-[1000px] gap-4 bg-gray-200 border-gray-200 rounded p-5">

        <div class="bg-white p-8 rounded">
            <div class="flex mb-5">
                <a href="{{ route('petugas.penjualan.printPDF' , $penjualan->id) }}"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Unduh</a>
                <a href="{{ route('petugas.penjualan.index') }}"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Kembali</a>
            </div>
            <div class="flex justify-between">
                <div class="text-gray-500">
                    @if ($penjualan->member)
                    <p class="font-bold">{{ $penjualan->member->no_telp }}</p>
                    <p>Member Sejak : {{ $penjualan->member->created_at }}</p>
                    <p>Member Poin Tersisa : {{ $penjualan->member->PoinToBeUsed }}</p>
                    @endif
                </div>
                <div class="text-gray-500">
                    <p>Invoice - #{{ $penjualan->id }}</p>
                    <p>{{ $penjualan->created_at }}</p>
                </div>
            </div>

            <table class="mt-10 w-full text-sm text-center text-gray-700 border border-collapse border-gray-200">
                <thead class="text-xs text-gray-500 uppercase border-b border-gray-300">
                    <tr>
                        <th scope="col" class="py-3 px-4">Produk</th>
                        <th scope="col" class="py-3 px-4">Harga</th>
                        <th scope="col" class="py-3 px-4">Quantity</th>
                        <th scope="col" class="py-3 px-4">Sub Total</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($penjualan_detail as $product)
                        <tr class="border-b border-gray-200">
                            <td class="py-2 px-4">{{ $product->product->nama_product }}</td>
                            <td class="py-2 px-4">Rp. {{ number_format($product->product->harga, 0, ',', '.') }}</td>
                            <td class="py-2 px-4">{{ $product->qty }}</td>
                            <td class="py-2 px-4">Rp. {{ number_format($product->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-between">
                <div class="bg-gray-200 gap-4 w-full p-5">
                    <div class="flex gap-20">
                        <div class="">
                            <p class="text-xs">POIN DIGUNAKAN</p>
                            <p class="font-bold text-lg">{{ $penjualan->poin_used }}</p>
                        </div>
                        <div class="">
                            <p class="text-xs">KASIR</p>
                            <p class="font-bold text-lg">{{ $penjualan->user->name }}</p>
                        </div>
                        <div class="">
                            <p class="text-xs">KEMBALIAN</p>
                            <p class="font-bold text-lg">{{ $penjualan->change }}</p>
                        </div>
                    </div>
    
                </div>
                <div class="bg-black p-5 w-[400px] text-gray-200">
                    <p class="text-xs">TOTAL</p>
                    <p class="text-3xl">Rp{{ $penjualan->totalafterpoin }}</p>
                </div>
            </div>
        </div>

    </div>
@endsection