<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticle2tagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('article2tags', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('tags_id');
            $table->integer('article_id');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['tags_id', 'article_id']);
            $table->index('tags_id');
            $table->index('article_id');
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
        Schema::drop('article2tags');
    }
}
