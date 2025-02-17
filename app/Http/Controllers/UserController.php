<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{


    public function store(Request $request)
    {
        $superadminPassword = Hash::make('superadmin123');
        $unitPassword = Hash::make('unit123');
        $viewerPassword = Hash::make('viewer123');

        // Store the hashed passwords in the database
        User::create([
            'username' => 'superadmin',
            'role' => 'superadmin',
            'password' => $superadminPassword,
        ]);

        User::create([
            'username' => 'unit',
            'role' => 'unit',
            'password' => $unitPassword,
        ]);

        User::create([
            'username' => 'viewer',
            'role' => 'viewer',
            'password' => $viewerPassword,
        ]);
    }
}
