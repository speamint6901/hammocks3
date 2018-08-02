<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemEvaluationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_evaluation', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('items_id');
            $table->float('average');
            $table->timestamps();
            $table->softDeletes();
            $table->index('items_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('item_evaluation');
    }
}
