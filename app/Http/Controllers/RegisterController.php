<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RegisterContorller extends Controller
{
    //
    public function register():View{
        return view('auth.register');
    }
}
