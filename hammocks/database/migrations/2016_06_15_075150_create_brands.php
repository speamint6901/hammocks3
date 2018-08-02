<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('brands', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 255);
            $table->string('brand_img_url', 255)->nullable()->default(NULL);
            $table->string('name_hiragana', 255)->nullable()->default(NULL);
            $table->string('name_katakana', 255)->nullable()->default(NULL);
            $table->string('name_japan', 255)->nullable()->default(NULL);
            $table->string('name_display', 255);
            $table->string('name_category', 1);
            $table->string('name_category_kana', 2);
            $table->timestamps();
            $table->softDeletes();
            $table->index('name');
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
        Schema::connection('master')->drop('brands');
    }
}
