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
           $providerUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return 'Error retrieving user information: ' . $e->getMessage();
        }

        // Check if user information is available
        if (!$providerUser) {
            return 'Failed to retrieve user information.';
        }

        // Determine the value for the 'name' column
        $name =$providerUser->name ?:$providerUser->nickname;

        $user = User::updateOrCreate([
            'provider_id' =>$providerUser->id,
            'provider' => $provider
        ], [
            'name' => $name,
            'email' =>$providerUser->email,
            'provider_token' =>$providerUser->token,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
