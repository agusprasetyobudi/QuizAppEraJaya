<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function SocialLogin($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function SocialCallBack($callback)
    {
        $user = Socialite::driver($callback)->user();
        dd($user);
    }
}
