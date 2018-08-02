<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreEvaluation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('master')->create('store_evaluation', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('store_id');
            $table->tinyInteger('average');
            $table->timestamps();
            $table->softDeletes();
            $table->index('store_id');
            $table->index('average');
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
        Schema::connection('master')->drop('store_evaluation');
    }
}
