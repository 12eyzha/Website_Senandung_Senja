<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * LIST MENU (ADMIN)
     * - bisa lihat semua (aktif / nonaktif)
     * - support search
     * - pagination
     */
    public function index(Request $request)
    {
        $query = Menu::query();

        // SEARCH
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // FILTER CATEGORY
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // FILTER AVAILABILITY
        if ($request->filled('is_available')) {
            $query->where('is_available', $request->is_available);
        }

        $menus = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($menus);
    }

    /**
     * CREATE MENU
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $menu = Menu::create([
            ...$validated,
            'is_available' => true,
        ]);

        return response()->json([
            'message' => 'Menu berhasil ditambahkan',
            'data' => $menu,
        ], 201);
    }

    /**
     * DETAIL MENU
     */
    public function show($id)
    {
        $menu = Menu::findOrFail($id);

        return response()->json($menu);
    }

    /**
     * UPDATE MENU
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $menu->update($validated);

        return response()->json([
            'message' => 'Menu berhasil diupdate',
            'data' => $menu,
        ]);
    }

    /**
     * TOGGLE AVAILABILITY
     */
    public function toggle($id)
    {
        $menu = Menu::findOrFail($id);

        $menu->update([
            'is_available' => ! $menu->is_available,
        ]);

        return response()->json([
            'message' => 'Status menu diperbarui',
            'is_available' => $menu->is_available,
        ]);
    }

    /**
     * DELETE MENU
     * (hard delete, aman karena transaksi pakai snapshot)
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return response()->json([
            'message' => 'Menu berhasil dihapus',
        ]);
    }
}
