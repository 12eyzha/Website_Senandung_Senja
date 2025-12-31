<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * 🔹 LAPORAN HARIAN (PDF)
     * ?date=2025-12-24
     */
    public function daily(Request $request)
    {
        $date = $request->date ?? now()->toDateString();

        $transactions = Transaction::with('user')
            ->whereDate('created_at', $date)
            ->where('status', 'completed')
            ->get();

        $pdf = Pdf::loadView('reports.daily', [
            'date'         => $date,
            'transactions' => $transactions,
            'summary'      => [
                'total_transactions' => $transactions->count(),
                'total_revenue'      => (int) $transactions->sum('total_amount'),
            ]
        ]);

        return $pdf->download("laporan-harian-$date.pdf");
    }

    /**
     * 🔹 LAPORAN BULANAN (PDF)
     * ?month=12&year=2025
     */
    public function monthly(Request $request)
    {
        $month = $request->month ?? now()->month;
        $year  = $request->year ?? now()->year;

        $transactions = Transaction::with('user')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'completed')
            ->get();

        $pdf = Pdf::loadView('reports.monthly', [
            'month'        => $month,
            'year'         => $year,
            'transactions' => $transactions,
            'summary'      => [
                'total_transactions' => $transactions->count(),
                'total_revenue'      => (int) $transactions->sum('total_amount'),
            ]
        ]);

        return $pdf->download("laporan-bulanan-$month-$year.pdf");
    }

    /**
     * 🔹 LAPORAN PER USER (PDF)
     */
    public function perUser($userId) 
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $transactions = Transaction::where('user_id', $userId)
            ->where('status', 'completed')
            ->get();

        $pdf = Pdf::loadView('reports.per-user', [
            'user'         => $user,
            'transactions' => $transactions,
            'summary'      => [
                'total_transactions' => $transactions->count(),
                'total_revenue'      => (int) $transactions->sum('total_amount'),
            ]
        ]);

        return $pdf->download("laporan-user-{$user->id}.pdf");
    }

    /**
     * 🔹 LAPORAN SEMUA TRANSAKSI (PDF)
     */
    public function all()
    {
        $transactions = Transaction::with('user')
            ->where('status', 'completed')
            ->latest()
            ->get();

        $pdf = Pdf::loadView('reports.all', [
            'transactions' => $transactions,
            'summary'      => [
                'total_transactions' => $transactions->count(),
                'total_revenue'      => (int) $transactions->sum('total_amount'),
            ]
        ]);

        return $pdf->download('laporan-semua-transaksi.pdf');
    }
    /**
 * 🔹 LAPORAN PER TRANSAKSI (PDF)
 */
public function perTransaction($id)
{
    $transaction = Transaction::with(['user', 'items.menu'])
        ->where('id', $id)
        ->where('status', 'completed')
        ->first();

    if (!$transaction) {
        return response()->json([
            'message' => 'Transaksi tidak ditemukan'
        ], 404);
    }

    $pdf = Pdf::loadView('reports.per-transaction', [
        'transaction' => $transaction
    ]);

    return $pdf->download("transaksi-{$transaction->transaction_code}.pdf");
}

}
