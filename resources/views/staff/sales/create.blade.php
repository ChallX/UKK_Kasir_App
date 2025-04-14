@extends('layouts.dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-10">Penjualan</h1>

    <form action="{{ route('petugas.penjualan.checkout') }}" method="POST">
        @csrf

        <div class="border gap-4 w-[1000px] border-gray-200 grid grid-cols-3 justify-end rounded p-10">
            @foreach ($products as $product)
                <div class="border border-gray-200 rounded p-4 flex items-center justify-center text-center">
                    <div>
                        <img class="rounded-md mb-2 mx-auto" width="200" height="100"
                            src="{{ asset('storage/produk/' . $product->image) }}" alt="">
                        <p class="text-gray-500 font-semibold">{{ $product->nama_product }}</p>
                        <p class="text-sm text-gray-400 font-semibold">Stok : 
                            <span id="stok-{{ $product->id }}">{{ $product->stock }}</span>
                        </p>
                        <p class="font-bold text-gray-500">{{ $product->harga }}</p>

                        <div class="flex text-gray-500 font-semibold gap-2 justify-center items-center mt-2">
                            <button type="button" onclick="decreaseQty({{ $product->id }})">-</button>
                            <p id="qty-{{ $product->id }}">0</p>
                            <button type="button" onclick="increaseQty({{ $product->id }}, {{ $product->stock }})">+</button>
                        </div>

                        <input type="hidden" name="produk[{{ $product->id }}]" id="input-qty-{{ $product->id }}" value="0">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-center mt-10">
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Selanjutnya
            </button>
        </div>
    </form>

    <script>
        function increaseQty(id, stok) {
            const qtyEl = document.getElementById(`qty-${id}`);
            const inputQtyEl = document.getElementById(`input-qty-${id}`);
            let currentQty = parseInt(qtyEl.innerText);

            if (currentQty < stok) {
                currentQty += 1;
                qtyEl.innerText = currentQty;
                inputQtyEl.value = currentQty;
            } else {
                alert('Stok Barang Habis');
            }
        }

        function decreaseQty(id) {
            const qtyEl = document.getElementById(`qty-${id}`);
            const inputQtyEl = document.getElementById(`input-qty-${id}`);
            let currentQty = parseInt(qtyEl.innerText);

            if (currentQty > 0) {
                currentQty -= 1;
                qtyEl.innerText = currentQty;
                inputQtyEl.value = currentQty;
            } else {
                alert('Minimal pembelian adalah 1');
            }
        }
    </script>
@endsection