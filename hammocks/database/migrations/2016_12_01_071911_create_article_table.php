<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            //
            $table->integer('id', true);
            $table->integer('user_items_id');
            $table->integer('users_id');
            $table->tinyInteger('status')->default(0); //公開ステータス(0:非公開 1:公開)
            $table->text('title')->nullable()->default(NULL);
            $table->text('article_text')->nullable()->default(NULL);
            $table->string('img_url')->nullable()->default(NULL);
            $table->timestamps();
            $table->softDeletes();
            $table->index('user_items_id');
            $table->index('users_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('master')->drop('article');
    }
}
