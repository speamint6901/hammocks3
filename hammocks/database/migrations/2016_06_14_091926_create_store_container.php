<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreContainer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('master')->create('store_container', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('store_id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
            $table->index('store_id');
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
        Schema::connection('master')->drop('store_container');
    }
}
