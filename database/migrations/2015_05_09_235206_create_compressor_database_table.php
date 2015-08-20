<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompressorDatabaseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('compressordatabase', function($table)
	    {
	        $table->increments('id');
	        $table->string('size');
	        $table->integer('displ_capacity');
	        $table->integer('HP_displ');
	        $table->integer('emp_hp_factor');
	        $table->integer('nom_rpm');
	        $table->integer('max_rpm');
	        $table->integer('min_rpm');
	        $table->float('air_ve_part_1');
	        $table->float('air_ve_part_2');
	        $table->timestamps();
	    });
	}

	public function down()
	{
	    Schema::drop('compressordatabase');
	}	

}
