@extends('layouts.dashboard')

@section('content')
    <h1 class="text-lg font-bold mb-5">Dashboard</h1>

    <div class="border border-gray-200 rounded-md p-2 w-[1000px]">
        <h1 class="font-bold">Selamat Datang, Petugas!</h1>

        <div class=" p-2 text-gray-600 text-center">
            <div class="p-2 rounded-t-md bg-gray-300">
                <p>Total Penjualan Hari Ini</p>
            </div>
            <div class="p-5">
                <p class="text-gray-800 font-semibold">{{$penjualan}}</p>
                <p>Jumlah total penjualan yang terjadi hari ini.</p>
            </div>
            <div class="p-2 rounded-b-md bg-gray-300">
                <p>Terakhir diperbarui: 09 Apr 2025 05:28</p>
            </div>
        </div>
    </div>
@endsection