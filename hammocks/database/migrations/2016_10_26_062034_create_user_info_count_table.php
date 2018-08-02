<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfoCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_info_count', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('users_id');
            $table->integer('have_count')->default(0)->unsigned();
            $table->integer('want_count')->default(0)->unsigned();
            $table->integer('clip_count')->default(0)->unsigned();
            $table->integer('evaluation_count')->default(0)->unsigned();
            $table->integer('follow_count')->default(0)->unsigned();
            $table->integer('follower_count')->default(0)->unsigned();
            $table->integer('sale_count')->default(0)->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->index('users_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_info_count');
    }
}
