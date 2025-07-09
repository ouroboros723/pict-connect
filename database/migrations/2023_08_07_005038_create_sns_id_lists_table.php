<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSnsIdListsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('sns_id_lists', function(Blueprint $table) {
            $table->bigInteger('pc_user_id')->unsigned()->unique('sns_id_lists_pc_user_id_uindex')->comment('pict_connectユーザーid');
            $table->bigInteger('sns_id')->comment('連携先SNSid');
            $table->boolean('sns_type')->comment('SNS種別');
            $table->dateTime('created_at')->nullable()->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->comment('更新日時');
            $table->dateTime('deleted_at')->nullable()->comment('削除日時');
        });
        DB::statement("ALTER TABLE sns_id_lists COMMENT 'SNSidリスト'");
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('sns_id_lists');
	}

}
