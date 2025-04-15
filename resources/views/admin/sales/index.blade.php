@extends('layouts.dashboard')

@section('content')
    <h1 class="font-bold mb-5 text-xl">Penjualan</h1>

    <div class="border border-gray-200 p-4 rounded-md w-[1000px]">
        <div>
            <div class="flex">
                <a href="{{ route('admin.penjualan.exportExcelPenjualan') }}"
                    class="ml-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-sm text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Export
                    Penjualan (.xlsx)</a>
            </div>
            <table id="search-table">
                <thead>
                    <tr>
                        <th>
                            <span class="flex items-center">
                                Nama Pelanggan
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Tanggal Penjualan
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Total Harga
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Dibuat Oleh
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Action
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualans as $penjualan)
                        <tr>
                            @if ($penjualan->member)
                                <td>{{ $penjualan->member->nama_pelanggan }}</td>
                            @else
                                <td>NON-MEMBER</td>
                            @endif
                            <td>{{ $penjualan->created_at }}</td>
                            <td>Rp{{ $penjualan->total }}</td>
                            <td>{{ $penjualan->user->name }}</td>
                            <td>
                                <button type="button" data-modal-target="default-modal-{{ $penjualan->id }}"
                                    data-modal-toggle="default-modal-{{ $penjualan->id }}"
                                    class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">Lihat</button>
                                <a href="{{ route('admin.penjualan.PrintPDF', $penjualan->id) }}"
                                    class="text-black bg-blue-400 hover:bg-blue-500 focus:ring-4 focus:ring-blue-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                                    Unduh Bukti
                                </a>
                            </td>
                        </tr>

                        <!-- Main modal -->
                        <div id="default-modal-{{ $penjualan->id }}" tabindex="-1" aria-hidden="true"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-3xl max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Detail Penjualan
                                        </h3>
                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="default-modal">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-4 md:p-5 space-y-4">
                                        @if ($penjualan->member)
                                            <div class="flex justify-between">
                                                <div class="text-sm">
                                                    <p>Member Status : {{ $penjualan->member->status_member }}</p>
                                                    <p>No Hp : {{ $penjualan->member->no_telp }}</p>
                                                    <p>Poin Tersisa : {{ $penjualan->member->PoinToBeUsed }}</p>
                                                </div>
                                                <div class="text-sm">
                                                    <p>Bergabung Sejak : {{ $penjualan->member->created_at }}</p>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="mt-4">
                                            <div class="grid grid-cols-4 font-semibold border-b pb-2 mb-2">
                                                <p>Nama Produk</p>
                                                <p>Qty</p>
                                                <p>Harga</p>
                                                <p>Subtotal</p>
                                            </div>
                                            @foreach ($penjualan->penjualanDetails as $product)
                                                <div class="grid grid-cols-4 py-2 border-b text-sm">
                                                    <p>{{ $product->product->nama_product }}</p>
                                                    <p>{{ $product->qty }}</p>
                                                    <p>Rp{{ number_format($product->product->harga, 0, ',', '.') }}</p>
                                                    <p>Rp{{ number_format($product->subtotal, 0, ',', '.') }}</p>
                                                </div>
                                            @endforeach
                                            <div class="flex">
                                                <p class="ml-auto font-bold text-lg">Total : Rp{{ $penjualan->totalafterpoin }}
                                                </p>
                                            </div>
                                            <div class="text-center">
                                                <p>Dibuat pada: {{ $penjualan->created_at }}</p>
                                                <p>Oleh: {{ $penjualan->user->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: '{{ session('error') }}',
            showConfirmButton: true
        });
    </script>
@endif
    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                sortable: false
            });
        }
    </script>
@endsection