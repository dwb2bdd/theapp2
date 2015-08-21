<?php namespace App\Http\Controllers;
use App\Sizing;
use App\User;

class AdminController extends Controller {

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


}