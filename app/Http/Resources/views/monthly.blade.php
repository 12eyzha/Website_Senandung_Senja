<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Bulanan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
        h2 { text-align: center; }
    </style>
</head>
<body>

<h2>LAPORAN TRANSAKSI BULANAN</h2>
<p><strong>Periode:</strong> {{ $month }} - {{ $year }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>User</th>
            <th>Total</th>
            <th>Metode</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $trx)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $trx->transaction_code }}</td>
            <td>{{ $trx->user->name ?? '-' }}</td>
            <td>Rp {{ number_format($trx->total_amount) }}</td>
            <td>{{ $trx->payment_method }}</td>
            <td>{{ $trx->created_at->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p>
    <strong>Total Transaksi:</strong> {{ $summary['total_transactions'] }} <br>
    <strong>Total Pendapatan:</strong> Rp {{ number_format($summary['total_revenue']) }}
</p>

</body>
</html>
