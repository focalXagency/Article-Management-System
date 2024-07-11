<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate( [
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $user->assignRole('Member');

        $data['token'] = $user->createToken($request->email)->plainTextToken;
        $data['user'] = $user;
        $response = [
            'status' => 'success',
            'message' => 'User is created successfully.',
            'data' => $data,
        ];
        return response()->json($response, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required','email','exists:users,email'],
            'password' =>['required','string'],
            ]);
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
                $user=Auth::user();
                $token=$user->createToken('sanctum',[])->plainTextToken;
                return response()->json([
                    'user'=>$user,
                    'token'=>$token,],
                    200);
            }
            return response()->json(false);
    }

        public function logout(Request $request)
        {
            auth()->user()->tokens()->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User is logged out successfully'
                ], 200);
        }
    }