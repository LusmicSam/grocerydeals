<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login()
    {
        // 10. Show redirecting to named routes after login: return redirect()->route('products.index')
        return redirect()->route('products.index');
    }

    public function logout()
    {
        return redirect()->route('home');
    }
}
