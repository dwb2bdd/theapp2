<?php namespace App\Services;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|confirmed|max:255|unique:users',
/*			'last_name' => 'required|max:255',
			'company' => 'required|max:255',
			'address' => 'required|max:255',
			'city_state' => 'required|max:255',
			'country' => 'required|max:255',
			'phone' => 'required|max:255',
			'user_type' => 'required|max:255',
			'primary_industry' => 'required|max:255',
			'password' => 'required|confirmed|min:6',
*/		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */

	public function create(array $data)
	{
		return User::create([
			'name' => $data['name'],
			'last_name' => $data['last_name'],
			'company' => $data['company'],
			'address' => $data['address'],
			'city_state' => $data['city_state'],
			'country' => $data['country'],
			'phone' => $data['phone'],
			'user_type' => $data['user_type'],
			'user_type_other' => $data['user_type_other'],
			'primary_industry' => $data['primary_industry'],
			'primary_industry_other' => $data['primary_industry_other'],
			'email' => $data['email'],
/*
			disable password due to requiring manual activation instead of auto
			'password' => bcrypt($data['password']),
*/			'password' => bcrypt('random1p3a1ssword'),
			'activated' => '0', //0 is off, 1 is activated
			'user_level' => 99, //regular user = 99, admin = 1, admin level2 = 2 and so on
		]);
	}

}
