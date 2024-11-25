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
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or password',
            ], 401);
        }

        $user = auth()->user()->makeHidden(['created_at', 'updated_at', 'deleted_at']);
        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json(['status' => "success", 'user' => $user, 'token' => $token]);
    }
}
