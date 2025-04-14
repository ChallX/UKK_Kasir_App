@extends('layouts.dashboard')

@section('content')
    <h1 class="text-xl font-bold mb-5">Penjualan</h1>

    <div class="flex border gap-[250px] w-[1000px] border-gray-200 p-5 rounded-md">
        <div>
            <p class="font-semibold text-lg">Produk yang dipilih</p>
            <p class="text-xs">Bibit Toge</p>
            <div class="flex mb-5 gap-20">
                <p class="text-xs">Rp. 100.000 X 2</p>
                <p class="font-bold text-xs"> Rp. 200.000 </p>
            </div>
            <div class="flex gap-20">
                <p class="text-lg font-bold">Total Harga</p>
                <p class="font-bold text-lg">Rp. 200.000</p>
            </div>
            <div class="flex gap-20">
                <p class="text-lg font-bold">Total Bayar</p>
                <p class="font-bold text-lg">Rp. 200.000</p>
            </div>
        </div>
        <div>
            <form class="max-w-sm mx-auto">
                <div class="mb-5">
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Member
                        (identitas)</label>
                    <select id="countries"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="Bukan Member">Bukan Member</option>
                        <option value="Member">Member</option>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Poin</label>
                    <input type="text" id="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required />
                    <div class="flex items-center mt-2 mb-4">
                        <input id="default-checkbox" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-checkbox"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Gunakan Poin <span class="text-red-500"> (Poin tidak dapat digunakan pada pembelanjaan pertama) </span></label>
                    </div>
                </div>
            </form>
            <div class="flex">
                <button type="button"
                    class="ml-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Pesan</button>
            </div>
        </div>
    </div>

@endsection