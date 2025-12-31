<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * 🔹 LIST SEMUA TRANSAKSI (ADMIN / DEBUG)
     */
    public function index()
    {
        return response()->json(
            Transaction::with(['user', 'items.menu'])
                ->latest()
                ->get()
        );
    }

    /**
     * 🔹 SIMPAN TRANSAKSI
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'items'            => 'required|array',
            'items.*.menu_id'  => 'required|exists:menus,id',
            'items.*.qty'      => 'required|integer|min:1',
            'payment_method'  => 'required|string',
        ]);

        // 🧾 BUAT TRANSAKSI
        $transaction = Transaction::create([
            'transaction_code' => 'TRX-' . strtoupper(Str::random(8)),
            'payment_method'   => $data['payment_method'],
            'payment_status'   => 'paid',
            'status'           => 'completed',
            'user_id'          => auth()->id(),
            'total_amount'     => 0,
        ]);

        $total = 0;

        // 📦 SIMPAN ITEM
        foreach ($data['items'] as $item) {
            $menu = Menu::findOrFail($item['menu_id']);

            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'menu_id'        => $menu->id,
                'qty'            => $item['qty'],
                'price'          => $menu->price,
            ]);

            $total += $menu->price * $item['qty'];
        }

        // 💰 UPDATE TOTAL
        $transaction->update([
            'total_amount' => $total
        ]);

        return response()->json([
            'message' => 'Transaksi berhasil',
            'data'    => $transaction->load('items.menu')
        ], 201);
    }

    /**
     * 🔹 HISTORY TRANSAKSI (FILTERABLE)
     */
    public function history(Request $request)
    {
        $query = Transaction::with('items.menu')
            ->where('user_id', $request->user()->id);

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('created_at', $request->month)
                  ->whereYear('created_at', $request->year);
        }

        return response()->json([
            'message' => 'History transaksi',
            'data'    => $query->latest()->get()
        ]);
    }

    /**
     * 🔹 RINGKASAN TRANSAKSI HARI INI
     */
    public function summary(Request $request)
    {
        $today = now()->toDateString();

        $transactions = Transaction::with('items')
            ->where('user_id', $request->user()->id)
            ->whereDate('created_at', $today)
            ->get();

        return response()->json([
            'message' => 'Ringkasan transaksi hari ini',
            'data' => [
                'total_transactions' => $transactions->count(),
                'total_revenue'      => (int) $transactions->sum('total_amount'),
                'total_items_sold'   => $transactions->sum(fn ($trx) =>
                    $trx->items->sum('qty')
                ),
            ]
        ]);
    }

    /**
     * 🔹 DETAIL TRANSAKSI
     */
    public function show($id)
    {
        $transaction = Transaction::with('items.menu')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$transaction) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Detail transaksi',
            'data'    => $transaction
        ]);
    }

    /**
     * 🔹 CANCEL TRANSAKSI
     */
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|min:5'
        ]);

        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        if ($transaction->status === 'cancelled') {
            return response()->json([
                'message' => 'Transaksi sudah dibatalkan'
            ], 400);
        }

        // ⏱ BATAS 5 MENIT
        $expiredAt = Carbon::parse($transaction->created_at)->addMinutes(5);

        if (now()->greaterThan($expiredAt)) {
            return response()->json([
                'message' => 'Transaksi tidak bisa dibatalkan (melewati batas waktu)'
            ], 403);
        }

        $transaction->update([
            'status'        => 'cancelled',
            'cancelled_at'  => now(),
            'cancel_reason' => $request->cancel_reason,
        ]);

        return response()->json([
            'message' => 'Transaksi berhasil dibatalkan',
            'data' => [
                'transaction_code' => $transaction->transaction_code,
                'status'           => $transaction->status,
                'cancel_reason'    => $transaction->cancel_reason,
            ]
        ]);
    }
}
