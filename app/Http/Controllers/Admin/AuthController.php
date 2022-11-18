<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('login.admin');
    }

    public function store(Request $request)
    {
        try {
            // dd($request->except('_token'));
            if(Auth::attempt($request->except('_token'))){
                $request->session()->regenerate();
                return redirect()->route('Admin.Dashboard');
            }
            Alert::error('Wrong email / password','');
            return redirect()->route('Admin.Login');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return response()->json(['message'=>'You Logged Out From System'],200);
    }
}
