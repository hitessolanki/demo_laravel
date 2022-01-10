<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TblUser;
use Crypt;
class UserController extends Controller
{
    // get all user
    public function index(){
    	return TblUser::all();
    }
    // Store individual user
    public function store(Request $request){
    	
        $validated = $this->validate($request,[
	        'username' => 'required',
	        'email' => 'required',
            'password' => 'required',
            'mobile_number' => 'required'
    	]);
        // print_r($request->all());die;
    	return TblUser::create($request->all());
    }

    // View individual user
    public function show($id){
    	return TblUser::find($id);
    }

     // Update a user
    public function update(Request $request, $id){
		$user=TblUser::find($id);
		$user->update($request->all());
		return $user;
    }

    // Delete a user
    public function destroy($id){
    	return TblUser::destroy($id);
    }
}
