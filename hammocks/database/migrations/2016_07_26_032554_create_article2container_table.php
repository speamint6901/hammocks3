<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticle2containerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('article2container', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('article_id');
            $table->integer('container_id');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['article_id', 'container_id']);
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
        Schema::drop('article2container');
    }
}
