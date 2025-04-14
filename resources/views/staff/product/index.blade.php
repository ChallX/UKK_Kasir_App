@extends('layouts.dashboard')

@section('content')
    <h1 class="font-bold mb-5 text-xl">Product</h1>

    <div class="border border-gray-200 p-4 rounded-md w-[1000px]">
        <div>
            <table id="search-table">
                <thead>
                    <tr>
                        <th>
                            <span class="flex items-center">
                                Nama Produk
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Harga
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Stok
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Apple Inc.</td>
                        <td>AAPL</td>
                        <td>$192.58</td>
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