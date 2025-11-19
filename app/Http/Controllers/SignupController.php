<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    public function index()
    {
        return view('pages.signup');
    }
    public function create_account(Request $request)
    {

        //validation step
        $request->validate([
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:20|confirmed|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/',
        ]);

        //pick from the form
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        //insert to db
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        //$user->save();//dave to db

        if($user->save()){
            //auth??
            return redirect('/dashboard');
        }else{
            return back()->with('error', 'Failed to create account');
        }


    }
}
