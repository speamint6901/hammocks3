<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserItemImgs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('master')->create('user_item_imgs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('users_items_id');
            $table->string('img_url');
            $table->timestamps();
            $table->softDeletes();
            $table->index('users_items_id');
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
        Schema::connection('master')->drop('user_item_imgs');
    }
}
