<?php

namespace App\Http\Controllers;

use App\Helpers\Utilities;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function index()
    {
        return view('pages.signup');
    }
    public function create(Request $request)
    {

        //validation step
        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^\+?[0-9]{10,15}$/',
//            'password' => 'required|min:6|max:20|confirmed|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/',
            'password' => 'required|min:6|max:20|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);

        //pick from the form
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $password = $request->input('password');

        //insert to db
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->phone = $phone;
        $user->password = Hash::make($password);
        $user->username = Utilities::generate_username_from_email($email);

        if($user->save()) {
            // If the user is saved, try to log in the user
            if (Auth::attempt(['email'=>$email, 'password'=>$password], $request->has('remember'))) {

                //send welcome email
                $email_status = Utilities::send_email_as_plaintext($email, "Welcome to Contact Manager App", "Hi $user->name, <br>Welcome to Contact Manager App! Your account has been created successfully and your username is @$user->username");

                //generate session and cache data
                $request->session()->regenerate();
                //track online status(last seen) every minute
                Cache::put('user-is-online-' . auth()->user()->id, true, now()->addMinutes(1));
                return redirect()->intended('/dashboard')->with('success', "Welcome aboard, $user->name!");

            } else {
                return back()->with('warning', 'Your account has been created but something went wrong. Please login.');
            }
        } else {
            return back()->with('error', 'Failed to create account');
        }

    }
}
