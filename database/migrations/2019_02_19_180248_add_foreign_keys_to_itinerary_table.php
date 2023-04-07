<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToItineraryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('itinerary', function(Blueprint $table)
		{
			$table->foreign('package_id', 'itinerary_package')->references('id')->on('packages')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('itinerary', function(Blueprint $table)
		{
			$table->dropForeign('itinerary_package');
		});
	}

}
