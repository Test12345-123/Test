<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogActivity;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            return view('pages.login.index');
        }
    }

    public function login_process(Request $request)
    {
        $login = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($login)) {
            if (auth()->check()) {
                if (auth()->user()->id_level == 3 || auth()->user()->id_level == 4) {
                    LogActivity::create([
                        'user_id' => auth()->user()->id,
                        'activity' => 'Logged In',
                    ]);

                    return redirect()->route('order');
                }

                return redirect()->route('dashboard');
            }
        }

        return redirect()->route('login')->withErrors(['email' => 'Email atau Password salah']);
    }



    public function logout()
    {
        if (auth()->check() && auth()->user()->id_level == 3 || auth()->check() && auth()->user()->id_level = 4) {
            LogActivity::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Logged Out',
            ]);
        }

        Auth::logout();
        return redirect('/');
    }
}
