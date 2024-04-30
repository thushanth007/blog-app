<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller
{
    function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    function callback(Request $request, $provider)
    {
        // Check if the request has any errors
        if ($request->has('error')) {
            return 'Error: ' . $request->error;
        }

        try {
            // Retrieve the user information
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return 'Error retrieving user information: ' . $e->getMessage();
        }

        // Check if user information is available
        if (!$socialUser) {
            return 'Failed to retrieve user information.';
        }

        // Determine the value for the 'name' column
        $name = $socialUser->name ?: $socialUser->nickname;

        $user = User::updateOrCreate([
            'provider_id' => $socialUser->id,
            'provider' => $provider
        ], [
            'name' => $name,
            'email' => $socialUser->email,
            'provider_token' => $socialUser->token,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
