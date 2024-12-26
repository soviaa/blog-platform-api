<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function register(Request $request){
        try{
            $request->validate([
                'username' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $user = new User();
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json([
                'message' => 'User registered successfully',
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'message' => 'Validation failed',
            ], 400);
        }
    }

    public function login(Request $request){
        try{
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $user = User::where('email', $request->email)->first();
            if(!$user || !Hash::check($request->password, $user->password)){
                return response()->json([
                    'message' => 'Invalid credentials',
                ], 401);
            }
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'token' => $token,
            ]);
            return response()->json([
                'message' => 'User logged in successfully',
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'message' => 'Validation failed',
                'exception' => $e->getMessage(),
            ], 400);
        }
    }

    public function viewProfile(){
        try{
            $user = User::where('id', Auth::user()->id)->first();
            return response()->json([
                'user' => $user,
                'message' => 'User retrieved successfully',
            ]);
        }catch(Exception $e){
            return response->json([
                'message' => 'Failed to retrieve user',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function updateProfile(Request $request){
        try{
            $user = User::where('id', Auth::user()->id)->first();
            $request->validate([
                'username' => 'nullable|string',
                'email' => 'nullable|email|unique:users,email',
            ]);
            $user->username = $request->username ?? $user->username;
            $user->email = $request->email ?? $user->email;
            $user->save();
            return response()->json([
                'user' => $user,
                'message' => 'Profile updated successfully',
            ]);
        }catch(Exception $e){
            return response()->json([
                'message' => 'Failed to update profile',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
