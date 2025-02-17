<?php

namespace App\Http\Controllers;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    public function getUnits($id)
    {
        $units = Unit::where('id_perusahaan', $id)->get();
        return response()->json($units);
    }
    public function home2()
{
    // Menghitung jumlah unik id_unit
    $jumlahUnit = DB::table('unit')->select('id_unit')->distinct()->count();
    // Menghitung jumlah unik id_pendaftaran
    $jumlahGrup = DB::table('pendaftaran')->select('id_pendaftaran')->distinct()->count();
    // Menghitung jumlah komite (manager)
    $jumlahManager = DB::table('tb_user')->where('role_user', 'manager')->count();

    return view('unit.home2', compact('jumlahUnit', 'jumlahGrup', 'jumlahManager'));
}

    public function daftarImprovement()
    {
        return view('unit/daftarImprovement');
    }
    public function pendaftaran2()
    {
        return view('unit/pendaftaran2');
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
        $units = Unit::where('id_perusahaan', $id_perusahaan)->get();
        return response()->json($units);
    }


}

