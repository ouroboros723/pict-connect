<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyEventsAddColumnPhotoPathAndPeriod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('icon_path')->nullable()->comment('イベントアイコンのパス');
            $table->dateTime('event_period_start')->comment('イベント開催期間(開始)');
            $table->dateTime('event_period_end')->comment('イベント開催期間(終了)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['icon_path', 'event_period_start', 'event_period_end']);
        });
    }
}
