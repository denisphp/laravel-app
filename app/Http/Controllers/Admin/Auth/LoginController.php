<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function getLogin()
    {

        return view('admin/auth/login');
    }

    public function postLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (auth()->guard('admin')->attempt(['email' => $email, 'password' => $password])) {
            return redirect()->intended('admin');
        }

        return redirect()->intended('admin/login')->with('status', 'Invalid Login Credentials !');
    }


    public function logout()
    {
        auth()->guard('admin')->logout();

        return redirect()->intended('admin/login');
    }
}
