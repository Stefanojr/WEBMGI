<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{

    public function unitByPerusahaan($id_perusahaan)
    {
        $units = Unit::where('id_perusahaan', $id_perusahaan)
            ->orderBy('nama_unit', 'asc') // ascending (A-Z)
            ->get();

        return response()->json($units);
    }

    // Menyimpan unit baru
    public function store(Request $request)
    {
        $request->validate([
            'id_perusahaan' => 'required|integer',
            'nama_unit' => 'required|string|max:255'
        ]);

        $unit = Unit::create([
            'id_perusahaan' => $request->id_perusahaan,
            'nama_unit' => $request->nama_unit,
            'ka_unit' => '' // default jika belum ada inputan ka_unit
        ]);

        return response()->json(['success' => true, 'unit' => $unit]);
    }

    // (Opsional) Untuk menghapus unit
    public function destroy($id)
    {
        $unit = Unit::find($id);

        if ($unit) {
            $unit->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Unit tidak ditemukan'], 404);
    }

    // (Opsional) Ambil data unit untuk edit
    public function edit($id)
    {
        $unit = Unit::find($id);
        return response()->json($unit);
    }

    // (Opsional) Update data unit
    public function update(Request $request, $id)
    {
        $unit = Unit::find($id);

        if ($unit) {
            $unit->update(['nama_unit' => $request->nama_unit]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Unit tidak ditemukan'], 404);
    }


    // Di UnitController.php
    public function show($id_unit)
    {
        $unit = Unit::find($id_unit);
        if ($unit) {
            return response()->json($unit); // ✅ penting: return langsung object
        } else {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }


    public function home2()
    {
        $userId = auth()->id();
        $pendaftarans = Pendaftaran::where('id_user', $userId)
            ->with(['files' => function($query) {
                $query->orderBy('id_step', 'asc');
            }])
            ->get();

        // Menghitung jumlah unik id_unit
        $jumlahUnit = DB::table('unit')->select('id_unit')->distinct()->count();
        // Menghitung jumlah unik id_pendaftaran
        $jumlahGrup = DB::table('pendaftaran')->select('id_pendaftaran')->distinct()->count();
        // Menghitung jumlah komite (manager)
        $jumlahManager = DB::table('users')->where('role_user', 'manager')->count();

        return view('unit.home2', compact('jumlahUnit', 'jumlahGrup', 'jumlahManager', 'pendaftarans'));
    }

    public function daftarImprovement()
    {
        return view('unit/daftarImprovement');
    }
    public function pendaftaran()
    {
        return view('unit/pendaftaran');
    }
    public function risalah2()
    {
        return view('unit/risalah2');
    }
    public function approval2()
    {
        return view('unit/approval2');
    }
    public function timetable()
    {
        return view('unit/timetable');
    }
    public function qcdsmpe()
    {
        return view('unit/qcdsmpe');
    }
    public function arsip2()
    {
        return view('unit/arsip2');
    }
    public function arsipfoto2()
    {
        return view('unit/arsipfoto2');
    }

    public function getUnitsByPerusahaan($id_perusahaan)
    {
        $units = Unit::where('id_perusahaan', $id_perusahaan)
            ->orderBy('nama_unit', 'asc') // ascending (A-Z)
            ->get();

        return response()->json($units);
    }

    public function getPerusahaanByUnit($id_unit)
    {
        // Ambil dari view (view_unit_perusahaan)
        $unit = DB::table('view_unit_perusahaan')->where('id_unit', $id_unit)->first();

        if ($unit) {
            return response()->json(['id_perusahaan' => $unit->id_perusahaan]);
        }

        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }
}
