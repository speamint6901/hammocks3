<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConfirmationTokenToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('confirmation_token')->nullable();  // 確認用トークン
            $table->timestamp('confirmed_at')->nullable();  // 確認日時
            $table->timestamp('confirmation_sent_at')->nullable();  // 確認メール送信日時
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn([
                'confirmation_token',
                'confirmed_at',
                'confirmation_sent_at'
            ]);
        });
    }
}
