<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function generateToken(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:2',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();
        \Log::info($user);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'username' => ['The provided credentials are incorrect.'],
            ], 401);
        }

        return response()->json([
            'access_token' => $user->createToken('auth')->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }

    public function registerAndGenerateToken(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:2|max:255|unique:'.User::class,
            'password' => 'required',
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'access_token' => $user->createToken('auth')->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }
}
