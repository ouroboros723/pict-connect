<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function (){
            Schema::create('album_photos', function (Blueprint $table) {
                $table->id('album_master_id')->comment('アルバム-写真id');
                $table->unsignedBigInteger('user_id')->comment('アルバムマスタid');
                $table->unsignedBigInteger('event_id')->nullable()->comment('イベントid');
                $table->unsignedBigInteger('photo_id')->comment('写真id');
                $table->dateTime('created_at')->nullable()->comment('作成日時');
                $table->dateTime('updated_at')->nullable()->comment('更新日時');
                $table->dateTime('deleted_at')->nullable()->comment('削除日時');
            });

            DB::statement("ALTER TABLE album_photos COMMENT 'アルバム-写真'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('album_photos');
    }
}
