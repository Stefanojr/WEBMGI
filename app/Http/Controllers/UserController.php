<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Unit;
use App\Models\Perusahaan;

class UserController extends Controller
{

    public function index()
    {
        // Ambil data users dari model
        $users = User::all(); // atau gunakan query builder sesuai dengan kebutuhan

        // Ambil data unit, jika diperlukan untuk dropdown
        $units = Unit::all();
        $perusahaans = Perusahaan::all();

        // Kirimkan data ke view
        return view('superadmin.users', compact('users', 'units', 'perusahaans'));
    }

    public function getData()
    {
        return response()->json(User::all());
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'perner' => 'required',
                'password' => 'required',
                'nama_user' => 'required',
                'email_user' => 'required',
            ]);

            User::create([
                'id_unit' => $request->id_unit,
                'perner' => $request->perner,
                'password' => Hash::make($request->password),
                'nama_user' => $request->nama_user,
                'email_user' => $request->email_user,
                'role_user' => $request->role_user,
                'aktif' => $request->aktif ?? 1,
                'created_at' => now()
            ]);

            return response()->json([
                'success' => true

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'id_unit' => $request->id_unit,
            'perner' => $request->perner,
            'nama_user' => $request->nama_user,
            'email_user' => $request->email_user,
            'role_user' => $request->role_user,
            'aktif' => $request->aktif,
        ]);

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return response()->json(['success' => true]);
    }


    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data tidak ditemukan atau kesalahan saat menghapus.'], 500);
        }
    }
}
