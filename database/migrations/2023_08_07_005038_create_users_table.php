<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->bigInteger('user_id')->unsigned()->unique('users_user_id_uindex');
			$table->string('screen_name')->nullable();
			$table->string('view_name')->nullable();
			$table->string('password')->nullable();
			$table->text('user_icon_path')->nullable();
			$table->text('token')->nullable();
			$table->text('token_sec')->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->text('description')->nullable();
			$table->boolean('is_from_sns')->default(0);
			$table->string('email')->nullable();
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
		Schema::dropIfExists('users');
	}

}
