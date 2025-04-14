@extends('layouts.dashboard')

@section('content')
    <h1 class="text-lg mb-5 font-bold">Penjualan</h1>

    <div class="grid grid-cols-1 border border-gray-200 p-2 rounded-lg w-[1000px] md:grid-cols-3 gap-4 p-4">

        <div class="border border-gray-200 rounded-md p-4 flex flex-col items-center text-center">
          <img src="https://via.placeholder.com/150" alt="Apel" class="w-32 h-32 object-cover rounded-t-md mb-2">
          <p class="font-semibold text-lg">Apel</p>
          <p class="text-sm text-gray-600">Stok: 10</p>
          <p class="font-semibold text-green-600 mt-1">Rp. 30.000</p>
      
          <div class="flex items-center gap-4 my-2">
            <button class="px-3 py-1 bg-gray-200 rounded">-</button>
            <span>0</span>
            <button class="px-3 py-1 bg-gray-200 rounded">+</button>
          </div>
      
          <p class="text-sm">Sub Total: <span class="font-semibold">Rp. 0</span></p>
        </div>
      

        <div class="border border-gray-200 rounded-md p-4 flex flex-col items-center text-center">
          <img src="https://via.placeholder.com/150" alt="Jeruk" class="w-32 h-32 object-cover rounded-t-md mb-2">
          <p class="font-semibold text-lg">Jeruk</p>
          <p class="text-sm text-gray-600">Stok: 15</p>
          <p class="font-semibold text-green-600 mt-1">Rp. 25.000</p>
      
          <div class="flex items-center gap-4 my-2">
            <button class="px-3 py-1 bg-gray-200 rounded">-</button>
            <span>0</span>
            <button class="px-3 py-1 bg-gray-200 rounded">+</button>
          </div>
      
          <p class="text-sm">Sub Total: <span class="font-semibold">Rp. 0</span></p>
        </div>
      
    
        <div class="border border-gray-200 rounded-md p-4 flex flex-col items-center text-center">
          <img src="https://via.placeholder.com/150" alt="Pisang" class="w-32 h-32 object-cover rounded-t-md mb-2">
          <p class="font-semibold text-lg">Pisang</p>
          <p class="text-sm text-gray-600">Stok: 20</p>
          <p class="font-semibold text-green-600 mt-1">Rp. 20.000</p>
      
          <div class="flex items-center gap-4 my-2">
            <button class="px-3 py-1 bg-gray-200 rounded">-</button>
            <span>0</span>
            <button class="px-3 py-1 bg-gray-200 rounded">+</button>
          </div>
      
          <p class="text-sm">Sub Total: <span class="font-semibold">Rp. 0</span></p>
        </div>
      </div>

      <div class="flex justify-center  mt-4">
        <button type="button" class=" items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Lanjutkan Pesanan</button>
      </div>
      
@endsection