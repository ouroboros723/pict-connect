<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateGuestLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_logins', function (Blueprint $table) {
            $table->id('guest_login_id')->comment('ゲストログインid');
            $table->string('sns_screen_name', 255)->comment('連携先SNS スクリーンネーム(@hoge)');
            $table->tinyInteger('sns_type')->comment('SNS種別');
            $table->string('guest_token', 64)->comment('認証トークン');
            $table->dateTime('created_at')->nullable()->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->comment('更新日時');
            $table->dateTime('deleted_at')->nullable()->comment('削除日時');
        });

        DB::statement("ALTER TABLE guest_logins COMMENT 'ゲストログイン'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guest_logins');
    }
}
