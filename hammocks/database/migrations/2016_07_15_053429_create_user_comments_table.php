<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_comments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('users_id');
            $table->integer('user_items_id');
            $table->tinyInteger('is_owner')->default(0);
            $table->text('comment');
            $table->timestamps();
            $table->softDeletes();
            $table->index('user_items_id');
            $table->index(['user_items_id', 'users_id']);
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
        Schema::drop('user_comments');
    }
}
