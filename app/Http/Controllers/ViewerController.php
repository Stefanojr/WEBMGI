<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewerController extends Controller
{
    // app/Http/Controllers/SuperadminController.php


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
}

