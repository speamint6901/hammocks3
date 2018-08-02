<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreEvaluationUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('master')->create('store_evaluation_users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('users_id');
            $table->integer('store_id');
            $table->tinyInteger('evaluation_num');
            $table->timestamps();
            $table->softDeletes();
            $table->unique('users_id', 'store_id');
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
        Schema::connection('master')->drop('store_evaluation_users');
    }
}
