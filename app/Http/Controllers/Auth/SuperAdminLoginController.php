<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuperAdminLoginController extends Controller
{
    //
    public function showLoginForm(){
        return view('admin.login');
    }
    public function login(Request $request){
        dd($request->all());
    }
}
