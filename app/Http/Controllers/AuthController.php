<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string'
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $save = $user->save();

        if ($save) {
            return response()->json(['message' => 'Register success.'], 200);
        } else {
            return response()->json(['message' => 'Register failed.'], 500);
        }
    }

    //
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|string'
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials)){
            return response()->json(['message' => 'Email or Password wrong'], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('auth_token');
        $token = $tokenResult->plainTextToken;

        return response()->json(['token' => 'Bearer ' . $token], 200);
    }
}
