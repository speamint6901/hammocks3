<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenreSecondTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genre_second', function (Blueprint $table) {
            //
            $table->integer('id', true);
            $table->integer('category_id');
            $table->integer('genre_id');
            $table->string('name', 255);
            $table->timestamps();
            $table->softDeletes();
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('genre_second');
    }
}
