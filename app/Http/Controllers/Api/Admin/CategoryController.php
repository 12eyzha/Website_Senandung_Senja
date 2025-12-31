<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * LIST CATEGORY
     */
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        return response()->json($categories);
    }

    /**
     * CREATE CATEGORY
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $category,
        ], 201);
    }

    /**
     * UPDATE CATEGORY
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Kategori berhasil diperbarui',
            'data' => $category,
        ]);
    }

    /**
     * DELETE CATEGORY
     * ❗ Ditolak jika masih dipakai menu
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->menus()->exists()) {
            return response()->json([
                'message' => 'Kategori masih digunakan oleh menu',
            ], 422);
        }

        $category->delete();

        return response()->json([
            'message' => 'Kategori berhasil dihapus',
        ]);
    }
}
