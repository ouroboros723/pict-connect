<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventJoinTokenModifyNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_join_tokens', function (Blueprint $table) {
            $table->dateTime('expired_at')->nullable()->comment('有効期限')->change();
            $table->unsignedInteger('limit_times')->nullable()->comment('使用可能回数')->change();
            $table->unsignedInteger('use_times')->nullable()->comment('使用された回数')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_join_tokens', function (Blueprint $table) {
            $table->dateTime('expired_at')->nullable(false)->comment('有効期限')->change();
            $table->unsignedInteger('limit_times')->nullable(false)->comment('使用可能回数')->change();
            $table->unsignedInteger('use_times')->nullable(false)->comment('使用された回数')->change();
        });
    }
}
