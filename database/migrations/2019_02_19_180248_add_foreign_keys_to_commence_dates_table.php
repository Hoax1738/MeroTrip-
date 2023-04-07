<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCommenceDatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('commence_dates', function(Blueprint $table)
		{
			$table->foreign('package_id', 'commence_date_package')->references('id')->on('packages')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('commence_dates', function(Blueprint $table)
		{
			$table->dropForeign('commence_date_package');
		});
	}

}
