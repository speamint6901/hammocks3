<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFollow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('master')->create('user_follow', function (Blueprint $table) {
            $table->integer('users_id');
            $table->integer('user_follower_count')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->primary('users_id');
            $table->index('user_follower_count');
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
        Schema::connection('master')->drop('user_follow');
    }
}
