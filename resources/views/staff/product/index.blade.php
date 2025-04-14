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
                                Gambar Produk
                            </span>
                        </th>
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
                    @foreach ($products as $product)
                        <tr>
                            <td><img src="{{ asset('storage/produk/' . $product->image) }}" alt="" width="100"></td>
                            <td>{{ $product->nama_product }}</td>
                            <td>Rp{{ $product->harga }}</td>
                            <td>{{ $product->stock }}</td>
                        </tr>
                    @endforeach
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