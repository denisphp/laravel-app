<?php

namespace App\Http\Controllers\API\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Handle a profile request for the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function showProfile()
    {
        $user = Auth::guard('api')->user();

        return response()->json(['data' => ['user' => $user]]);
    }
}
