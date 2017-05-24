<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
//        return view('home');
        return 'admin home page';
    }

    public function dashboard()
    {

//        return view('backend.dashboard');
        return 'admin dashboard page';
    }
}
