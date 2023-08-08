<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function (){
            Schema::create('events', function (Blueprint $table) {
                $table->id('event_id')->comment('event_id');
                $table->string('event_name', 255)->comment('イベント名');
                $table->unsignedBigInteger('event_admin_id')->comment('イベント管理者id');
                $table->text('event_detail')->nullable()->comment('イベント詳細');
                $table->text('description')->nullable()->comment('備考');
                $table->dateTime('created_at')->nullable()->comment('作成日時');
                $table->dateTime('updated_at')->nullable()->comment('更新日時');
                $table->dateTime('deleted_at')->nullable()->comment('削除日時');
            });

            DB::statement("ALTER TABLE events COMMENT 'イベント'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
