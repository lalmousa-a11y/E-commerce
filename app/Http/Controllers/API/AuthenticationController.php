<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Seller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;


class AuthenticationController extends Controller
{
    public function register(RegisterRequest  $request)
    {
  
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->seller === true ? 'seller' : 'buyer'
        ]);

        // If seller is true, create seller record
        if ($request->seller === true) {
            Seller::create([
                'user_id' => $user->id,
                'is_approved' => false
            ]);
        }

        return response()->json(['message' => 'User registered successfully']);
    }
    public function login(LoginRequest  $request)
    {
  
        
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();

        // Check if user is seller and not approved
        if ($user->user_type === 'seller') {
            $seller = $user->seller;
            if (!$seller || !$seller->is_approved) {
                Auth::logout();
                return response()->json(['message' => 'Your seller account is pending approval'], 403);
            }
        }

        $token = $user->createToken('API Token')->plainTextToken;
        return response()->json(['token' => $token, 'user_type' => $user->user_type]);
    }
    public function userInfo(Request $request)
    {
        return response()->json($request->user());
    }
    public function logOut(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}