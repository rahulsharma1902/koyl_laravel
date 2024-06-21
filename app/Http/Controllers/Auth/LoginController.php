<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
    
        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    
        $user = Auth::user();
    
        if ($user->user_type == 'doctor' && $user->status == 1) {
            Auth::logout(); 
            return response()->json(['error' => 'Your account is under approval. Please wait for confirmation.'], 401);
        }
    
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->token = $token;
    
        return response()->json($user);
    }
}
