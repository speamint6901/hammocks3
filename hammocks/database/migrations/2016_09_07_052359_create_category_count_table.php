<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_count', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('category_id');
            $table->integer('count');
            $table->timestamps();
            $table->softDeletes();
            $table->index('category_id');
            $table->index(['category_id', 'count']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('category_count');
    }
}
