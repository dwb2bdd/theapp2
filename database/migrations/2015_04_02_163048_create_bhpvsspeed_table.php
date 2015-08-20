<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBhpvsspeedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('bhpvsspeed', function($table)
	    {
	        $table->increments('id');
	        $table->string('speed');
	        $table->string('brake_hp');
	        $table->string('scfm');
	        $table->timestamps();
	    });
	}

	public function down()
	{
	    Schema::drop('bhpvsspeed');
	}	

}
