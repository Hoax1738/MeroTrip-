<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCommitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('commits', function(Blueprint $table)
		{
			$table->foreign('commence_date_id', 'commit_commence_date_id')->references('id')->on('commence_dates')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id', 'commit_user')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('commits', function(Blueprint $table)
		{
			$table->dropForeign('commit_commence_date_id');
			$table->dropForeign('commit_user');
		});
	}

}
