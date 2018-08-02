<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('category_id');
            $table->integer('genre_id')->nullable()->default(null);
            $table->integer('genre_second_id')->nullable()->default(null);
            $table->integer('brands_id');
            $table->tinyInteger('status')->default(0); //公開ステータス(0:非公開 1:公開)
            $table->string('name', 255);
            $table->string('img_url', 100)->nullable()->default(null);
            $table->string('img_site_url', 255)->nullable()->default(null);
            $table->integer('article_count')->default(0);
            $table->integer('want_count')->default(0);
            $table->integer('have_count')->default(0);
            $table->text('description')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->index('category_id');
            $table->index('genre_id');
            $table->index('genre_second_id');
            $table->index('brands_id');
            $table->index('want_count');
            $table->index('have_count');
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
        Schema::connection('master')->drop('items');
    }
}
