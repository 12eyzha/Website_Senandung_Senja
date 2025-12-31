<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Ambil daftar menu (API)
     * Support:
     * - search (?search=kopi)
     * - pagination (?page=1&per_page=8)
     */
    public function index(Request $request)
    {
        $query = Menu::query()
            ->where('is_available', true)
            ->orderBy('name');

        // 🔍 SEARCH NAMA MENU
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 📄 PAGINATION
        $perPage = $request->per_page ?? 8;
        $menus = $query->paginate($perPage);

        return response()->json([
            'data' => $menus->items(),
            'meta' => [
                'current_page' => $menus->currentPage(),
                'last_page'    => $menus->lastPage(),
                'per_page'     => $menus->perPage(),
                'total'        => $menus->total(),
            ],
        ]);
    }
}
