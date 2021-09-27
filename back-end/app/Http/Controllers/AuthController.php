<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = Validator::make(
            $request->all(),
            [
                'firstname' => ['required', 'max:26'],
                'surname' => ['required', 'max:26'],
                'email' => ['required', 'email', 'unique:users'],
                'storename' => ['required', 'min:6', 'max:26'],
                'subdomain' => ['required', 'min:6', 'unique:users'],
                'country' => ['required'],
                'mobile_number' => ['regex:/^(?:(?:(?:\+|00)212[\s]?(?:[\s]?\(0\)[\s]?)?)|0){1}(?:5[\s.-]?[2-3]|6[\s.-]?[13-9]){1}[0-9]{1}(?:[\s.-]?\d{2}){3}$/'],
                'password' => ['required', 'confirmed', 'min:6', 'max:26']
            ]
        );
        if ($fields->fails()) {
            return response()->json([
                'message' => 'failed', 'error' => $fields->errors()
            ], 400);
        }
        $user = User::create([
            'firstname' => $request->firstname,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'storename' => $request->storename,
            'subdomain' => $request->subdomain,
            'country' => $request->country,
            'mobile_number' => $request->mobile_number,
        ]);
        if ($user) {
            $token = $user->createToken('token')->plainTextToken;
            $response = ['message' => 'success', 'token' => $token];
            return response($response, 201);
        }
        $response = [
            'message' => 'failed',
        ];
        return response($response, 500);
    }

    public function login(Request $request)
    {
        $fields = Validator::make(
            $request->all(),
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'string']
            ]
        );
        if ($fields->fails()) {
            return response()->json(['message' => "enter your information!", $fields->errors()], 422);
        }
        // Check email
        $user = User::where('email', $request->email)->first();

        // Check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'email or password is wrong'
            ], 401);
        }
        if (!$user->email_verified_at) {
            return response([
                'message' => 'Verified your account!'
            ], 403);
        }
        $token = $user->createToken('token')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    public function logout(Request $request)
    {
        // Revoke all tokens...
        auth()->user()->tokens()->delete();
        return response(['message' => 'Logged out'], 201);
    }
}
