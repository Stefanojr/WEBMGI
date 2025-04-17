<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Http\Requests\StorePerusahaanRequest;
use App\Http\Requests\UpdatePerusahaanRequest;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    public function index()
    {
        $perusahaans = Perusahaan::all();
        return view('superadmin.masterData', compact('perusahaans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
        ]);

        if ($request->id_perusahaan) {
            $perusahaan = Perusahaan::findOrFail($request->id_perusahaan);
            $perusahaan->update(['nama_perusahaan' => $request->nama_perusahaan]);
            return response()->json(['message' => 'Data berhasil diupdate']);
        } else {
            Perusahaan::create(['nama_perusahaan' => $request->nama_perusahaan]);
            return response()->json(['message' => 'Data berhasil ditambahkan']);
        }
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        return response()->json($perusahaan);
    }

    public function destroy($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
