<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SysadminController extends Controller
{
    public function home4()
    {
        return view('sysadmin/home4');
    }
    public function ManagementUser()
    {
        return view('sysadmin/ManagementUser');
    }
    public function perusahaan()
    {
        return view('sysadmin/perusahaan');
    }
    public function unit()
    {
        return view('sysadmin/unit');
    }
    public function user()
    {
        return view('sysadmin/user');
    }


}
