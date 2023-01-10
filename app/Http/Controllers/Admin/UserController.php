<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(){
        menuSubmenu('users', 'allUsers');
        return view('admin.user.index',['users'=>User::all()]);
    }
    public function show($id){
        menuSubmenu('users', 'allUsers');
        return view('admin.user.view',['user'=>User::find($id)]);
    }
    public function create(){
        menuSubmenu('users', 'createUser');
        return view('admin.user.create');
    }
    public function store(Request $request){
        $this->validate($request,[
            'name'      => 'required',
            'email'     => 'required|unique:users,email',
            'password'  => 'required|min:8'
        ]);
        User::createUser($request);
        menuSubmenu('users', 'createUser');
        return redirect('/admin/user-create')->with('success','User Create Successfuly !');
    }
}
