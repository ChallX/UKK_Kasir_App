<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bukti Pembelian</title>
    <style>
        body {
            font-size: 12px;
        }

        .receipt h3 {
            text-align: center;
            margin-bottom: 0;
        }

        .receipt p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th, td {
            padding: 4px 0;
            font-size: 12px;
        }

        th {
            text-align: left;
            border-bottom: 1px dashed #000;
        }

        td {
            vertical-align: top;
        }

        .totals td {
            font-weight: bold;
            padding-top: 5px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="receipt">
        <h3>PURE CART</h3>
        <p class="center">{{ $penjualan->created_at->format('d/m/Y H:i') }}</p>
        <p>Petugas: <strong>{{ $penjualan->user->name }}</strong></p>

        @if ($penjualan->member)
            <p>Member: {{ ucfirst($penjualan->member->status_member) }}</p>
            <p>No HP: {{ $penjualan->member->no_telp }}</p>
            <p>Sejak: {{ \Carbon\Carbon::parse($penjualan->member->created_at)->translatedFormat('d F Y') }}</p>
            <p>Poin Yang Tersisa: {{ $penjualan->member->PoinToBeUsed }}</p>
        @else
            <p>Non Member</p>
        @endif

        <div class="line"></div>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="right">Qty</th>
                    <th class="right">Harga</th>
                    <th class="right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualan->penjualanDetails as $item)
                    <tr>
                        <td>{{ $item->product->nama_product }}</td>
                        <td class="right">{{ $item->qty }}</td>
                        <td class="right">Rp{{ number_format($item->product->harga, 0, ',', '.') }}</td>
                        <td class="right">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="line"></div>

        <table class="totals">
            <tr>
                <td>Poin Digunakan</td>
                <td class="right">{{ $penjualan->poin_used ?? 0 }}</td>
            </tr>
            <tr>
                <td>Total Harga</td>
                <td class="right">Rp{{ number_format($penjualan->total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Setelah Poin</td>
                <td class="right">Rp{{ number_format($penjualan->totalafterpoin, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Kembalian</td>
                <td class="right">Rp{{ number_format($penjualan->change, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="line"></div>
        <p class="center"><strong>Terima kasih!</strong></p>
    </div>
</body>

</html>
