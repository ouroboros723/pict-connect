<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('users', function (Blueprint $table) {
//            $table->bigIncrements('user_id');
//            $table->string('screen_name', 255)->unique();
//            $table->string('view_name', 255);
//            $table->string('email', 255)->unique()->nullable();
//            $table->timestamp('email_verified_at')->nullable();
//            $table->string('password');
//            $table->text('user_icon_path')->nullable();
//            $table->text('token')->unique();
//            $table->text('token_sec')->unique();
//            $table->text('description')->nullable();
//            $table->unsignedTinyInteger('is_from_sns')->unique();
//            $table->rememberToken();
//            $table->softDeletes();
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('users');
    }
}
