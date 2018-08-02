<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFollowers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_followers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('users_id');
            $table->integer('user_follow_id');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['users_id', 'user_follow_id', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::connection('master')->drop('user_followers');
    }
}
