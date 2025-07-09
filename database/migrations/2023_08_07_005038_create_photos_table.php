<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePhotosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('photos', function(Blueprint $table)
        {
            $table->bigInteger('photo_id', true)->unsigned()->comment('写真id');
            $table->bigInteger('user_id')->nullable()->comment('投稿ユーザーid');
            $table->bigInteger('event_id')->nullable()->comment('イベントid');
            $table->text('store_path')->nullable()->comment('写真保存パス');
            $table->dateTime('created_at')->nullable()->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->comment('更新日時');
            $table->dateTime('deleted_at')->nullable()->comment('削除日時');
        });

        DB::statement("ALTER TABLE photos COMMENT '写真'");
    }


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('photos');
	}

}
