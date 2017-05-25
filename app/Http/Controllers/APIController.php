<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use JWTAuth;

class APIController extends Controller
{
    public function register(Request $request)
    {
        $input = $request->json()->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $token = Auth::guard('api')->setApiToken($user);

        return response()->json(['data' => ['token' => $token]]);
    }

    public function login(Request $request)
    {
        $input = $request->json()->all();

        if (!$token = Auth::guard('api')->attempt($input)){
            return response()->json(['data' => 'wrong email or password.']);
        }

        return response()->json(['data' => ['token' => $token]]);
    }

    public function get_user_details(Request $request)
    {
        $user = Auth::guard('api')->user();

        return response()->json(['data' => ['user' => $user]]);
    }
}
