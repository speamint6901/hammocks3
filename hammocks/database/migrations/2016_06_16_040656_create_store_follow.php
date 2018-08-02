<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreFollow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('master')->create('store_follow', function (Blueprint $table) {
            $table->integer('store_id');
            $table->integer('store_follower_count');
            $table->timestamps();
            $table->softDeletes();
            $table->primary('store_id');
            $table->index('store_follower_count');
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
        Schema::connection('master')->connection('master')->drop('store_follow');
    }
}
