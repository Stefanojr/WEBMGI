<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class SuperadminController extends Controller
{
    public function home()
    {
        // Menghitung jumlah unik id_pendaftaran
        $jumlahGrup = DB::table('pendaftaran')->select('id_pendaftaran')->distinct()->count();

        return view('superadmin.home', compact('jumlahGrup'));
    }
    public function pendaftaran()
    {
        return view('superadmin/pendaftaran');
    }
    public function daftarImprovementSA()
    {
        return view('superadmin/daftarImprovementSA');
    }
    public function daftarApproval()
    {
        return view('superadmin/daftarApproval');
    }
    public function arsip()
    {
        return view('superadmin/arsip');

    }
    public function report()
    {
        return view('superadmin/report');

    }
}

