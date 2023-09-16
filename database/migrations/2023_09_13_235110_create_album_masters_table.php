<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function (){
            Schema::create('album_masters', function (Blueprint $table) {
                $table->id('album_master_id')->comment('アルバムマスタid');
                $table->unsignedBigInteger('user_id')->comment('作成ユーザーid');
                $table->unsignedBigInteger('event_id')->nullable()->comment('イベントid');
                $table->unsignedTinyInteger('open_range_flag')->comment('公開範囲フラグ');
                $table->dateTime('created_at')->nullable()->comment('作成日時');
                $table->dateTime('updated_at')->nullable()->comment('更新日時');
                $table->dateTime('deleted_at')->nullable()->comment('削除日時');
            });

            DB::statement("ALTER TABLE album_masters COMMENT 'アルバムマスター'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('album_masters');
    }
}
