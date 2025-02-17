<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        if ($user->role == 'superadmin') {
            return redirect()->route('superadmin.home');
        } elseif ($user->role == 'unit') {
            return redirect()->route('unit.home2');

        }
    }
}
