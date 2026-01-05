<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * LIST KASIR
     */
    public function index()
    {
        return response()->json(
            User::where('role', 'kasir')
                ->orderBy('created_at', 'desc')
                ->get()
        );
    }

    /**
     * CREATE KASIR
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'role'      => 'kasir',
            'is_active' => true,
        ]);

        return response()->json([
            'message' => 'Kasir berhasil ditambahkan',
            'data' => $user,
        ], 201);
    }

    /**
     * UPDATE KASIR
     */
    public function update(Request $request, $id)
    {
        $user = User::where('role', 'kasir')->findOrFail($id);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'Data kasir berhasil diperbarui',
        ]);
    }

    /**
     * TOGGLE AKTIF / NONAKTIF
     */
    public function toggle($id)
    {
        $user = User::where('role', 'kasir')->findOrFail($id);

        $user->update([
            'is_active' => ! $user->is_active,
        ]);

        return response()->json([
            'message' => 'Status kasir diperbarui',
            'is_active' => $user->is_active,
        ]);
    }

    /**
     * DELETE (OPTIONAL)
     */
    public function destroy($id)
    {
        $user = User::where('role', 'kasir')->findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'Kasir berhasil dihapus',
        ]);
    }
}
