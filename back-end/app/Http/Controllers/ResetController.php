<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as RulesPassword;

class ResetController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $email = Validator::make($request->only('email'), ['email' => ['required', 'email', 'exists:users']]
        );
        if ($email->fails()) {
            return response()->json(['failed', $email->errors()], 400);
        }
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
            ? response(['status' => 'success', 'message' => __($status)], 201)
            : response(['status' => 'error', 'email' => __($status)], 400);
    }

    public function reset(Request $request)
    {
        $fields = Validator::make($request->all(), [
            'token' => ['required'],
            'email' => ['required', 'email', 'exists:password_resets'],
            'password' => ['required', 'confirmed', RulesPassword::defaults()]
        ]);
        if ($fields->fails()) {
            return response()->json(['failed', $fields->errors()], 400);
        }
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message' => 'Password reset successfully'
            ], 201);
        }
        return response([
            'message' => __($status)
        ], 500);
    }
}
