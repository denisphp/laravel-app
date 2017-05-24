<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
//        $user = auth()->guard('admin')->user();
//        print_r($user); die();
        return view('admin.dashboard');
    }
}
