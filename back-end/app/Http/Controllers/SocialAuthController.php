<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;


class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
        // return Socialite::driver($provider)->asPopup()->redirect();

    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        if (!$user->token) {
            // return json
            $response = [
                'user' => "",
                'token' => "",
                'new' => "",
                'error' => "true"
            ];

            // Create new view (I use callback.blade.php), and send the token and the name.
            return view('callback', $response);

        }
        $appUser = User::whereEmail($user->email)->first();
        // hna kanjib user li 3ando dak email
        $newUser = "false";

        if (!$appUser) {
            // create new user and add provider
            $newUser = "true";
            $nameUser = explode(' ', $user->name);

            $appUser = User::create([
                'firstname' => $nameUser[0],
                'surname' => $nameUser[1],
                'password' => Str::random(8),
                'email' => $user->email,
            ]);

            //create social account
            $socialAccount = SocialAccount::create([
                'provider' => $provider,
                'provider_user_id' => $user->id,
                'user_id' => $appUser->id,
            ]);
        } else {
            // means that we have already this user
            $socialAccount = $appUser->socialAccounts()->where('provider', $provider)->first();

            if (!$socialAccount) {
                //create social account
                $socialAccount = SocialAccount::create([
                    'provider' => $provider,
                    'provider_user_id' => $user->id,
                    'user_id' => $appUser->id,
                ]);
            }
            //
        }
        // login our user send the token

        $TokenUser = $appUser->createToken('token')->plainTextToken;
        $response = [
            'user' => $appUser->firstname,
            'token' => $TokenUser,
            'new' => $newUser,
            'error' => "false"
        ];

        // Create new view (I use callback.blade.php), and send the token and the name.
        return view('callback', $response);
    }
}
