<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|min:8',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json([
                'message' => ['This user already exists.']
            ], Response::HTTP_NOT_ACCEPTABLE);
        }

        $insertUserData = User::create([
            "full_name" => $request->full_name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            'role' => 'admin'
        ]);

        $token = $insertUserData->createToken($request->email)->plainTextToken;
        return response()->json([
            'user' => $insertUserData,
            "token" => $token
        ], Response::HTTP_CREATED);
    }

    /**
     * User login 
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => ['Invalid Email or password.']
            ], Response::HTTP_NOT_FOUND);
        }

        $token = $user->createToken($user->email)->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], Response::HTTP_CREATED);
    }

    /**
     * User logout 
     */
    public function logout(Request $request)
    {
        return $request->user()->currentAccessToken()->delete();
    }
}
