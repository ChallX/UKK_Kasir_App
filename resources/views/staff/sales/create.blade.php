@extends('layouts.dashboard')

@section('content')
  <h1 class="text-lg mb-5 font-bold">Penjualan</h1>

  <div class="grid grid-cols-1 border border-gray-200 p-2 rounded-lg w-[1000px] md:grid-cols-3 gap-4 p-4">
    @foreach ($products as $product)
    <div class="border border-gray-200 rounded-md p-4 flex flex-col items-center text-center">
    <img src="{{ asset('storage/produk/' . $product->image) }}" alt="" class="w-32 h-32 object-contain rounded-t-md mb-2">
    <p class="font-semibold text-lg">{{ $product->nama_product }}</p>
    <p class="text-sm text-gray-600">Stok: {{ $product->stock }}</p>
    <p class="font-semibold text-gray-600 mt-1">Rp.{{ $product->harga }}</p>

    <div class="flex items-center gap-4 my-2">
      <button class="px-3 py-1 bg-gray-200 rounded">-</button>
      <span>0</span>
      <button class="px-3 py-1 bg-gray-200 rounded">+</button>
    </div>
    </div>
  @endforeach
  </div>

  <div class="flex justify-center  mt-4">
    <button type="button"
    class=" items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Lanjutkan
    Pesanan</button>
  </div>

@endsection