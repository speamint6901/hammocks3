<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleContainerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_container', function (Blueprint $table) {
            //
            $table->integer('id', true);
            $table->integer('users_id');
            $table->string('name');
            $table->integer('count');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['users_id', 'created_at']);
            $table->index(['users_id', 'count']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('article_container');
    }
}
