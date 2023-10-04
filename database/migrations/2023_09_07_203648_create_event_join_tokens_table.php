<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventJoinTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function (){
            Schema::create('event_join_tokens', function (Blueprint $table) {
                $table->id('event_join_token_id')->comment('イベント参加トークンid');
                $table->unsignedBigInteger('event_id')->comment('イベントid');
                $table->string('join_token', 64)->comment('イベント参加トークン');
                $table->dateTime('expired_at')->comment('有効期限');
                $table->unsignedInteger('limit_times')->comment('使用可能回数');
                $table->unsignedInteger('use_times')->comment('使用された回数');
                $table->dateTime('created_at')->nullable()->comment('作成日時');
                $table->dateTime('updated_at')->nullable()->comment('更新日時');
                $table->dateTime('deleted_at')->nullable()->comment('削除日時');
            });

            DB::statement("ALTER TABLE event_join_tokens COMMENT 'イベント参加トークン'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_join_tokens');
    }
}
