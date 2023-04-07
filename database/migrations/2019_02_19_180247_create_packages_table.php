<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePackagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('packages', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title', 100);
			$table->string('slug', 100)->unique();
			$table->text('description', 65535)->nullable();
			$table->string('destination', 150);
			$table->integer('featured')->nullable();
			$table->integer('special_offer')->nullable();
			$table->integer('views')->default('5')->nullable();
			$table->text('images', 65535);
			$table->text('inclusions', 65535)->nullable();
            $table->text('exclusions')->nullable();
			$table->text('highlights', 65535)->nullable();
			$table->text('tags', 65535);
			$table->string('duration', 4);
			$table->text('travel_option', 65535)->nullable();
			$table->integer('created_by')->index('created_by');
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
		Schema::drop('packages');
	}

}
