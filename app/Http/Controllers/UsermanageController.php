<?php namespace App\Http\Controllers;

use App\User;

class UsermanageController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles registration
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		
	}

	public function index(){
		$users = User::paginate(5);
		return view('usermanage/index', ['users' => $users]);
	}	

	public function edit($id){
		$user = User::findOrFail($id);		
		return view ('usermanage/edit', ['user' => $user]);
	}

	public function update(){

	}	

	public function destroy(){

	}


}