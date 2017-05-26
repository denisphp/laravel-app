<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $input = $request->json()->all();

        if (!$token = Auth::guard('api')->attempt($input)) {
            return response()->json(['data' => 'wrong email or password.']);
        }

        return response()->json(['data' => ['token' => $token]]);
    }
}
