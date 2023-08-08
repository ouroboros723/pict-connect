<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::transaction(function (){
            Schema::create('users', function(Blueprint $table)
            {
                $table->bigInteger('user_id')->unsigned()->unique('users_user_id_uindex')->comment('ユーザーid');
                $table->string('screen_name')->nullable()->comment('ScreenName');
                $table->string('view_name')->nullable()->comment('表示名');
                $table->string('password')->nullable()->comment('パスワード(ハッシュ化済み)');
                $table->text('user_icon_path')->nullable()->comment('ユーザーアイコンのパス');
                $table->text('token')->nullable()->comment('認証トークン');
                $table->text('token_sec')->nullable()->comment('認証トークン(sec)');
                $table->string('remember_token', 100)->nullable()->comment('rememberトークン');
                $table->text('description')->nullable()->comment('備考');
                $table->boolean('is_from_sns')->default(0)->comment('SNSログインを利用して登録したユーザーか？');
                $table->string('email')->nullable()->comment('メールアドレス');
                $table->dateTime('created_at')->nullable()->comment('作成日時');
                $table->dateTime('updated_at')->nullable()->comment('更新日時');
                $table->dateTime('deleted_at')->nullable()->comment('削除日時');
            });
            DB::statement("ALTER TABLE users COMMENT 'ユーザー'");
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}

}
