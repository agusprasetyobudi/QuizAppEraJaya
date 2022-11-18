<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function SocialRedirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function SocialCallback($provider)
    {
        $socialite = Socialite::driver($provider)->stateless()->user();
        if($findUser = User::where('email',$socialite->email)->first()){
            Auth::login($findUser);
            return redirect()->route('dashboard');
        }
        $user = User::create([
            'name' => $socialite->name,
            'email' => $socialite->email,
            'register_at' => $provider,
            'password' => Hash::make('password'),
            'social_token' => $socialite->token
        ]);
        $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
        $login = $user;
        $user->save();
        $login->attachRole(2);
        Auth::login($login);
        return redirect()->route('dashboard');
    }
}
