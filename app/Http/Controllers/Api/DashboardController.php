<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * 📊 PENJUALAN HARIAN (7 HARI)
     */
    public function dailySales()
    {
        $data = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'label' => 'Penjualan Harian',
            'data'  => $data
        ]);
    }

    /**
     * 📊 PENJUALAN BULANAN
     */
    public function monthlySales()
    {
        $data = Transaction::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json([
            'label' => 'Penjualan Bulanan',
            'data'  => $data
        ]);
    }

    /**
     * 📊 METODE PEMBAYARAN
     */
    public function paymentMethod()
    {
        $data = Transaction::select(
                'payment_method',
                DB::raw('COUNT(*) as total')
            )
            ->where('status', 'completed')
            ->groupBy('payment_method')
            ->get();

        return response()->json([
            'label' => 'Metode Pembayaran',
            'data'  => $data
        ]);
    }

    /**
     * 🔥 TOP MENU TERJUAL (RELASI)
     */
    public function topItems()
    {
        $transactions = Transaction::with('items.menu')
            ->where('status', 'completed')
            ->get();

        $items = [];

        foreach ($transactions as $trx) {
            foreach ($trx->items as $item) {
                $menu = $item->menu;
                if (!$menu) continue;

                if (!isset($items[$menu->id])) {
                    $items[$menu->id] = [
                        'name'  => $menu->name,
                        'qty'   => 0,
                        'price' => $menu->price,
                    ];
                }

                $items[$menu->id]['qty'] += $item->qty;
            }
        }

        usort($items, fn ($a, $b) => $b['qty'] <=> $a['qty']);

        return response()->json([
            'label' => 'Top Menu',
            'data'  => array_slice($items, 0, 5)
        ]);
    }
}
