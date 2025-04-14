@extends('layouts.dashboard')

@section('content')
    <h1 class="font-bold mb-5 text-xl">Penjualan</h1>

    <div class="border border-gray-200 p-4 rounded-md w-[1000px]">
        <div>
            <div class="flex justify-between">
                <button type="button" class=" text-black bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-200 font-medium rounded-sm text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Export Penjualan (.xlsx)</button>
                <a href="{{ route('petugas.penjualan.create') }}" class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-sm text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Tambah Penjualan</a>
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
                    <tr>
                        <td>Apple Inc.</td>
                        <td>AAPL</td>
                        <td>$192.58</td>
                        <td>Maman</td>
                        <td>
                            <button type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-sm text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Unduh Bukti</button>
                            <button type="button"
                                class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-sm text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">Lihat</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                sortable: false
            });
        }
    </script>
@endsection