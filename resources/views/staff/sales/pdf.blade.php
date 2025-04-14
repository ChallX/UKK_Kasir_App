<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pembelian</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 5px; text-align: left; }
        th { background: #eee; }
        .total-box td { font-weight: bold; }
    </style>
</head>
<body>

    <h3>Pure Cart</h3>

    @if ($penjualan->member)
        <p>Member Status : {{ ucfirst($penjualan->member->status_member) }}</p>
        <p>No. HP : {{ $penjualan->member->no_telp }}</p>
        <p>Bergabung Sejak : {{ \Carbon\Carbon::parse($penjualan->member->created_at)->translatedFormat('d F Y') }}</p>
        <p>Poin Member : {{ $penjualan->member->poin }}</p>
    @endif

    <table border="1">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>QTY</th>
                <th>Harga</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan->penjualanDetails as $item)
                <tr>
                    <td>{{ $item->product->nama_product }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp{{ number_format($item->product->harga, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="total-box" style="margin-top: 15px;">
        <tr>
            <td>Poin Digunakan</td>
            <td>{{ $penjualan->poin_used ?? 0 }}</td>
        </tr>
        <tr>
            <td>Total Harga</td>
            <td>Rp{{ number_format($penjualan->total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Harga Setelah Poin</td>
            <td>Rp{{ number_format($penjualan->totalafterpoin, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total Kembalian</td>
            <td>Rp{{ number_format($penjualan->change, 0, ',', '.') }}</td>
        </tr>
    </table>

    <p style="margin-top: 20px;">
        {{ $penjualan->created_at }} | {{ $penjualan->user->name }}
    </p>

    <p style="margin-top: 10px;"><strong>Terima kasih atas pembelian Anda!</strong></p>

</body>
</html>