<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>
    <style>
        body { font-family: Arial; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h2>Detail Transaksi</h2>

<p>
    Kode: {{ $transaction->transaction_code }} <br>
    Customer: {{ $transaction->user->name ?? '-' }} <br>
    Tanggal: {{ $transaction->created_at->format('d-m-Y H:i') }}
</p>

<table>
    <thead>
        <tr>
            <th>Menu</th>
            <th>Qty</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transaction->items as $item)
        <tr>
            <td>{{ $item->menu->name }}</td>
            <td>{{ $item->qty }}</td>
            <td>Rp {{ number_format($item->price) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Total: Rp {{ number_format($transaction->total_amount) }}</h3>

</body>
</html>
