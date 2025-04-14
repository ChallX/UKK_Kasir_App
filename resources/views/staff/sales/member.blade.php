@extends('layouts.dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-10">Penjualan</h1>

    <div class="border gap-4 w-[1000px] border-gray-200 rounded p-10">

        <div class="flex justify-between">
            <div class="border border-gray-500 p-5 w-[400px]">
                <div class="mb-5 flex gap-4 text-gray-500">
                    <p class="w-2/3">Nama Produk</p>
                    <p class="w-1/3 text-center">Qty</p>
                    <p class="w-1/3 text-center">Harga</p>
                    <p class="w-1/3 text-center">Sub Total</p>
                </div>
                @foreach ($penjualan_details as $product)
                    <div class="flex mb-5 gap-4 text-gray-500">
                        <p class="w-2/3">{{ $product->product->nama_product }}</p>
                        <p class="w-1/3 text-center">{{ $product->qty }}</p>
                        <p class="w-1/3 text-center">{{ $product->product->harga }}</p>
                        <p class="w-1/3 text-center">{{ $product->subtotal }}</p>
                    </div>
                @endforeach
                <div class="flex ">
                    <div class="ml-auto text-lg font-semibold">
                        <p class="w-3/3">Total Harga {{ $penjualan->total }}</p>
                        <p class="w-3/3">Total Bayar {{ $penjualan->amount_paid }}</p>
                    </div>
                </div>
            </div>
            <div class="w-[450px]">
                <form action="{{ route('petugas.penjualan.memberUpdate') }}" method="post">
                    @csrf
                    <input type="hidden" name="penjualan_id" value="{{ $penjualan->id }}">
                    <input type="hidden" name="member_id" value="{{ $penjualan->member_id }}">

                    <div class="mb-5">
                        @if ($penjualan->member && $penjualan->member->nama_pelanggan)
                            <label for="nama_member"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                Member (Identitas)</label>
                            <input type="text" name="nama_member" value="{{ $penjualan->member->nama_pelanggan }}"
                                id="nama_member"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @else
                            <label for="nama_member"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                Member (Identitas)</label>
                            <input type="text" name="nama_member" value="{{ $penjualan->member->nama_pelanggan }}"
                                id="nama_member"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @endif
                    </div>
                    <div class="mb-5">
                        <label for="poin"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Poin</label>

                        <input type="text" value="{{ $member->poin }}" id="poin"
                            class="mb-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            disabled />


                        <div class="flex items-center mb-4">
                            <input id="gunakan_poin" name="gunakan_poin" type="checkbox"
                                {{ $isFirstTransaction ? 'disabled' : '' }}
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="gunakan_poin" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                Gunakan Poin
                                @if ($isFirstTransaction)
                                    <span class="text-xs text-red-500 block">*Poin belum dapat digunakan karena ini
                                        transaksi
                                        pertama</span>
                                @endif
                            </label>
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Selanjutnya</button>
                </form>
            </div>
        </div>

    </div>
@endsection