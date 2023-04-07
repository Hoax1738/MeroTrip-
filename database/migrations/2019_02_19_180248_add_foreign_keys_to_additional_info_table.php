<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAdditionalInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('additional_info', function(Blueprint $table)
		{
			$table->foreign('package_id', 'additional_info_package')->references('id')->on('packages')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('additional_info', function(Blueprint $table)
		{
			$table->dropForeign('additional_info_package');
		});
	}

}
