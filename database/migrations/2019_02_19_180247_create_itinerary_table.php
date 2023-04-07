<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItineraryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('itinerary', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('package_id')->index('package_id');
			$table->integer('day')->nullable();
			$table->string('title', 100)->nullable();
			$table->text('inclusions', 65535)->nullable();
            $table->text('exclusions', 65535)->nullable();
			$table->text('images', 65535)->nullable();
			$table->text('description', 65535)->nullable();
			$table->text('key_activities', 65535)->nullable();
			$table->string('destination_place', 200)->nullable();
			$table->string('end_of_day', 200)->nullable();
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('itinerary');
	}

}
