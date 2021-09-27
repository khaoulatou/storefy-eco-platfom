<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{

    public function sendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response(['message' => 'Already Verified'], 201);
        }

        $request->user()->sendEmailVerificationNotification();

        return response(['message' => "link verification sended to your email!"], 201);
    }

    public function verify(Request $request)
    {
        $user = User::findOrFail($request->id);
        // dd($user);
        // do this check, only if you allow unverified user to login
        //        if (! hash_equals((string) $request->id, (string) $request->user()->getKey())) {
        //            throw new AuthorizationException;
        //        }

        if (!hash_equals((string)$request->hash, sha1($user->getEmailForVerification()))) {
            return response()->json([
                "message" => "Unauthorized",
                "success" => false
            ], 401);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                "message" => "User already verified!",
                "success" => false
            ], 403);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json([
            "message" => "Email verified successfully!",
            "success" => true
        ], 201);
    }

    public function resendVerificationEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                "message" => "Failed to send!",
                "success" => false
            ], 500);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            "message" => "Check your email!",
            "success" => true
        ], 201);
    }
}
