<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEvaluationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_evaluation', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('users_id');
            $table->integer('evaluation_users_id');
            $table->tinyInteger('sale_type')->default(0); //購入者：0 出品者：1
            $table->tinyInteger('evaluation_type')->default(0); //悪い：0  良い：1
            $table->text('comment')->nullable()->default(NULL);
            $table->timestamps();
            $table->softDeletes();
            $table->index('users_id');
            $table->index('evaluation_users_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('master')->drop('user_evaluation');
    }
}
