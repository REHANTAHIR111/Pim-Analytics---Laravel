<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        if (\Auth::check()) {
            return Redirect::back();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL) && !preg_match('/^\+?\d{10,15}$/', $value)) {
                        $fail('Please Enter a valid email or phone number.');
                    }
                }
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^[a-zA-Z0-9._%+\-@]{8,16}$/'
            ],
        ], [
            'login.required' => 'Please enter email or phone.',
            'password.required' => 'Please enter your password.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Please enter a strong password.',
        ]);

        $login = $request->input('login');

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $login)->first();
            if (!$user) {
                return back()->withErrors(['login' => 'This email is not registered.'])->withInput();
            }
        } elseif (preg_match('/^\+?\d{10,15}$/', $login)) {
            $user = User::where('phone_number', $login)->first();
            if (!$user) {
                return back()->withErrors(['login' => 'This phone number is not registered.'])->withInput();
            }
        }

        // if (!Hash::check($request->password, $user->password)) {
        //     return back()->withErrors(['password' => 'Invalid password.'])->withInput();
        //     dd($request->password, $user->password);
        // }
        
        if (!\Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Invalid password.'])->withInput();
        }

        \Auth::login($user, $request->has('remember'));
        return redirect()->route('index')->with('message', 'You are Login Successfully!');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login')->with('message', 'You have been logged out Successfully!');
    }
}
