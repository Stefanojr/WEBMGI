<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PageController extends Controller
{


    public function index(){
        return view('welcome');
    }

    // superadmin

    public function home()
    {
        return view('superadmin/home');
    }
    public function pengajuan()
    {
        return view('superadmin/pengajuan');
    }
    public function proposal()
    {
        return view('superadmin/proposal');
    }
    public function approval()
    {
        return view('superadmin/approval');
    }


    // unit
    public function home2()
    {
        return view('unit/home2');
    }
    public function pendaftaran2()
    {
        return view('unit/pendaftaran2');
    }
    public function proposal2()
    {
        return view('unit/risalah2');
    }
    public function approval2()
    {
        return view('unit/approval2');
    }


      // viewer
      public function home3()
      {
          return view('viewer/home3');
      }
      public function pendaftaran3()
      {
          return view('viewer/pendaftaran3');
      }
      public function risalah3()
      {
          return view('viewer/risalah3');
      }
      public function approval3()
      {
          return view('viewer/approval3');
      }


      //Sysadmin

      public function home4()
      {
          return view('sysadmin/home4');
      }
      public function ManagementUser()
      {
          return view('sysadmin/ManagementUser');
      }

    //   Logout

    public function logout()
    {
        return view('/');
    }
}
