<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSnsIdListsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sns_id_lists', function(Blueprint $table)
		{
			$table->bigInteger('pc_user_id')->unsigned()->unique('sns_id_lists_pc_user_id_uindex');
			$table->bigInteger('sns_id');
			$table->boolean('sns_type');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('sns_id_lists');
	}

}
