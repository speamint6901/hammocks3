<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreFollowers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('master')->create('store_followers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('store_id');
            $table->integer('store_follow_id');
            $table->timestamps();
            $table->softDeletes();
            $table->unique('store_id', 'store_follow_id');
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
        Schema::drop('store_followers');
    }
}
