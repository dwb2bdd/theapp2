<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');

			$table->string('last_name');
			$table->string('company');
			$table->string('address');
			$table->string('city_state');
			$table->string('country');
			$table->string('phone' ->s);
			$table->string('user_type');
			$table->string('user_type_other');
			$table->string('primary_industry');
			$table->string('primary_industry_other');
			
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
