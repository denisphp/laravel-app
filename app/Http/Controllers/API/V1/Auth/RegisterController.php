<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $input = $request->json()->all();

        $validator = Validator::make($input, User::$createUserRules);
        if ($validator->fails()) {
            return ApiResponse::fail(400, ['user' => $validator->messages()]);
        }

        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $token = Auth::guard('api')->setApiToken($user);
        $response['user'] = $user->toArray();
        $response['token'] = $token;

        return ApiResponse::success($response);
    }
}
