<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $validateData = $request->validate([
            'email' => "required",
            'password' => "required"
        ]);

        if (!auth()->attempt($validateData)) {
            return response()->json(['message' => "Invalid token"], 401);
        }

        $user = auth()->user();
        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }
}
