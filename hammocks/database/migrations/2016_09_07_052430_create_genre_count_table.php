<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenreCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genre_count', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('genre_id');
            $table->integer('count');
            $table->timestamps();
            $table->softDeletes();
            $table->index('genre_id');
            $table->index(['genre_id', 'count']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('genre_count');
    }
}
