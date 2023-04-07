<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDesignerMetaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/*Schema::create('designer_meta', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('type', 30)->comment = 'tags|travel_option|itinerary_inc|hotel_inc|key_activities|additional_info';
			$table->string('name', 50);
			$table->string('slug', 50);
			$table->text('description', 65535);
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
		});
		*/
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Schema::drop('designer_meta');
	}

}
