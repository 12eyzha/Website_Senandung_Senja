<!DOCTYPE html>
<html>
<head>
    <title>Laporan User</title>
    <style>
        body { font-family: Arial; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h2>Laporan Transaksi User</h2>
<p>
    Nama: {{ $user->name }} <br>
    Email: {{ $user->email }}
</p>

<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Tanggal</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $trx)
        <tr>
            <td>{{ $trx->transaction_code }}</td>
            <td>{{ $trx->created_at->format('d-m-Y') }}</td>
            <td>Rp {{ number_format($trx->total_amount) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p>
    Total Transaksi: {{ $summary['total_transactions'] }} <br>
    Total Pendapatan: Rp {{ number_format($summary['total_revenue']) }}
</p>

</body>
</html>
