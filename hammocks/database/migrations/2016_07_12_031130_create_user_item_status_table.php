<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserItemStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_item_status', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('users_id');
            $table->integer('items_id');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['users_id', 'items_id']);
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
        Schema::drop('user_item_status');
    }
}
