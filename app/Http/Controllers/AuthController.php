<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'message' => 'login error username or password incorrect'
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'logged in succesfully',
            'email' => $user->email,
            'token' => $token
        ]);

    }

    public function logout(Request $request){
        
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'logged out succesfully'
        ]);
    }
}

