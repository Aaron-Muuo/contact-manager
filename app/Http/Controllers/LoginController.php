<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function submit(Request $request)
    {
        // Validate the request data
        $request->validate([
            'username' => 'required|string|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        //check if user is staff already
        $user = User::where('username', $username)->first();

        if (!$user) {
            return back()->withErrors([
                'username' => 'Account not found',
            ])->withInput();
        }

        if (Auth::attempt(['username' => $username, 'password' => $password], $request->has('remember'))) {
            $request->session()->regenerate();
            Cache::put('user-is-online-' . auth()->user()->id, true, now()->addMinutes(1));

            return redirect()->intended('/dashboard')->with('success', 'Welcome back!');
        } else {
            return back()->with('error', 'Invalid credentials');
        }
    }
}
