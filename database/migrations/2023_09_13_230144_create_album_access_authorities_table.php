<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAlbumAccessAuthoritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_access_authorities', function (Blueprint $table) {
            $table->id('album_access_authority_id')->comment('アルバムアクセス権限id');
            $table->unsignedBigInteger('album_photo_id')->comment('アルバム-写真id');
            $table->string('token', 255)->nullable()->comment('アクセストークン');
            $table->string('sns_screen_name', 255)->nullable()->comment('連携先SNS スクリーンネーム(@hoge)');
            $table->unsignedBigInteger('authorized_user_id')->nullable()->comment('承認済みユーザー');
            $table->boolean('is_writable')->comment('アルバム内容の変更の可否');
            $table->dateTime('created_at')->nullable()->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->comment('更新日時');
            $table->dateTime('deleted_at')->nullable()->comment('削除日時');
        });

        DB::statement("ALTER TABLE album_access_authorities COMMENT 'アルバムアクセス権限設定'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('album_access_authorities');
    }
}
