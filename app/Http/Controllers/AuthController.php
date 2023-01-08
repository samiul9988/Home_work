<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $credentials = $request->only('name','password');
            if(Auth::attempt($credentials)){
                if($request->user()->hasRole('Admin')){
                    return redirect()->route('admin/home')->with('sucess','Signed In !');
                }

                if($request->user()->hasRole('blog-admin')){
                    return redirect()->route('blog/home')->with('sucess','Signed In !');
                }
                return redirect()->intended('dashboard')->with('success','Signed In !');
            }
            return redirect('login')->with('error','Login details are not valid');
    }
}
