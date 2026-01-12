<!DOCTYPE html>
<html>
<head>
    <title>Laporan Harian</title>
    <style>
        body { font-family: Arial; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h2>Laporan Harian</h2>
<p>Tanggal: {{ $date }}</p>

<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>User</th>
            <th>Total</th>
            <th>Waktu</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $trx)
        <tr>
            <td>{{ $trx->transaction_code }}</td>
            <td>{{ $trx->user->name ?? '-' }}</td>
            <td>Rp {{ number_format($trx->total_amount) }}</td>
            <td>{{ $trx->created_at->format('H:i') }}</td>
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
