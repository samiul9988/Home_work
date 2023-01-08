<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class AuthController extends Controller
{
    public function index(){
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request){
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        $this->validate($request,[
            'email'    =>  'required',
            'password' =>  'required'
        ]);

        $credentials = $request->only('email','password');
            if(Auth::attempt($credentials)){
                if($request->user()->hasRole('Admin')){
                    return redirect()->route('admin/home')->with('sucess','Signed In !');
                }

                if($request->user()->hasRole('blog-admin')){
                    return redirect()->route('blog/home')->with('sucess','Signed In !');
                }
                return redirect()->intended('dashboard')->with('success','Signed In !');
            }
            return redirect()->route('login')->with('error','Login details are not valid');
    }

    public function dashboard(){
        if(Auth::check()){
            return view('user.dashboard',['user'=>Auth::user()]);
        }
        return redirect()->route('login')->with('error','You are not allowed to access');
    }

    public function logOut(){
        Session::flush();
        Auth::logout();
        return redirect('/login/');
    }
}
