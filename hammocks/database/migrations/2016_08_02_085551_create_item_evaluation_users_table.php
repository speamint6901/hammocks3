<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemEvaluationUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_evaluation_users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('users_id');
            $table->integer('item_evaluation_id');
            $table->tinyInteger('evaluation_num');
            $table->timestamps();
            $table->softDeletes();
            $table->index('item_evaluation_id');
            $table->unique(['users_id', 'item_evaluation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('item_evaluation_users');
    }
}
