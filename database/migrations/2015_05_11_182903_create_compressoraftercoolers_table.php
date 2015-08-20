<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompressoraftercoolersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('compressoraftercoolers', function(Blueprint $table)
		{
			$table->increments('id');
	        $table->string('sss_40psi');
	        $table->string('sss_30psi');
	        $table->string('sss_20psi');

	        $table->string('ss_40psi');
	        $table->string('ss_30psi');
	        $table->string('ss_20psi');

	        $table->string('approach_temp');

	        $table->string('selling_price');
	        $table->string('weight');

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
		Schema::drop('compressoraftercoolers');
	}

}
