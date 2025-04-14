@extends('layouts.dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-5">Penjualan</h1>

    <div class="border gap-4 w-[1000px] border-gray-200 rounded p-10">
        <div>
            <p class="text-xl font-semibold mb-4">Produk Yang Dipilih</p>
        </div>
        <div class="flex justify-between">
            <div class="text-gray-500">
                @php
                    $total = 0;
                @endphp

                @foreach ($produkDenganQty as $product)
                            @php
                                $subtotal = $product->jumlah_dipilih * $product->harga;
                                $total += $subtotal;
                            @endphp
                            <p>{{ $product->nama_product }}</p>
                            <div class="flex gap-54">
                                <div class="flex gap-1">
                                    <p>Rp{{ number_format($product->harga, 0, ',', '.') }}</p>
                                    <p>*</p>
                                    <p>{{ $product->jumlah_dipilih }}</p>
                                </div>
                                <div>
                                    <p class="font-bold">Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                @endforeach
                <div class="flex text-gray-500 gap-8 font-bold text-2xl">
                    <h1>Total</h1>
                    <p>Rp{{ number_format($total, 0, ',', '.') }}</p>
                </div>
            </div>
            <div>
                <form action="{{ route('petugas.penjualan.paymentHandle') }}" method="post" class="w-[300px]">
                    @csrf

                    <input type="hidden" name="total" value="{{ $total }}">

                    @foreach ($produkDenganQty as $product)
                                    @php
                                        $subtotal = $product->jumlah_dipilih * $product->harga;
                                    @endphp
                                    <input type="hidden" name="produk[{{ $product->id }}][id]" value="{{ $product->id }}">
                                    <input type="hidden" name="produk[{{ $product->id }}][nama_product]"
                                        value="{{ $product->nama_product }}">
                                    <input type="hidden" name="produk[{{ $product->id }}][harga]" value="{{ $product->harga }}">
                                    <input type="hidden" name="produk[{{ $product->id }}][jumlah_dipilih]"
                                        value="{{ $product->jumlah_dipilih }}">
                                    <input type="hidden" name="produk[{{ $product->id }}][subtotal]" value="{{ $subtotal }}">
                    @endforeach

                    <div class="mb-5">
                        <label for="member"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Member</label>
                        <select id="member" name="member"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="not_member">Bukan Member</option>
                            <option value="member">Member</option>
                        </select>
                    </div>
                    <div class="mb-5" id="no_telp_form" style="display: none;">
                        <label for="no_telp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No
                            Telp</label>
                        <input type="text" id="no_telp" name="no_telp"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Masukkan no telp" />
                    </div>
                    <div class="mb-5">
                        <label for="amount_paid" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total
                            Bayar</label>
                        <input type="number" id="amount_paid" name="amount_paid"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Masukkan jumlah pembayaran" />
                    </div>
                    <button type="submit" id="submit_button"
                        class="w-full px-4 py-2 text-white bg-gray-400 rounded-lg cursor-not-allowed"
                        disabled>Submit</button>
                </form>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const memberSelect = document.getElementById('member');
            const noTelpForm = document.getElementById('no_telp_form');
            const form = document.querySelector('form');
            const amountPaidInput = document.getElementById('amount_paid');
            const submitButton = document.getElementById('submit_button');
            const totalHarga = {{ $total }};

            // Tampilkan atau sembunyikan input no telp berdasarkan status member
            function toggleNoTelp() {
                if (memberSelect.value === 'member') {
                    noTelpForm.style.display = 'block';
                } else {
                    noTelpForm.style.display = 'none';
                }
            }

            // Validasi input pembayaran dan atur tombol submit aktif/tidak
            function validatePaymentInput() {
                const amountPaid = parseFloat(amountPaidInput.value);

                if (!isNaN(amountPaid) && amountPaid >= totalHarga) {
                    submitButton.disabled = false;
                    submitButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    submitButton.classList.add('bg-blue-700');
                } else {
                    submitButton.disabled = true;
                    submitButton.classList.remove('bg-blue-700');
                    submitButton.classList.add('bg-gray-400', 'cursor-not-allowed');
                }
            }

            // Hindari submit saat enter di select member
            memberSelect.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });

            // Event listeners
            memberSelect.addEventListener('change', toggleNoTelp);
            amountPaidInput.addEventListener('input', validatePaymentInput);

            // Inisialisasi saat pertama kali
            toggleNoTelp();
            validatePaymentInput();

            // Validasi saat form disubmit (optional, sebagai backup)
            form.addEventListener('submit', function (e) {
                const amountPaid = parseFloat(amountPaidInput.value);

                if (isNaN(amountPaid) || amountPaid < totalHarga) {
                    e.preventDefault();
                    alert('Total bayar tidak boleh kurang dari total harga barang!');
                    amountPaidInput.focus();
                }
            });
        });
    </script>

@endsection