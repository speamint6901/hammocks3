<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers2tagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('users2tags', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('tags_id');
            $table->integer('users_id');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['tags_id', 'users_id']);
            $table->index('users_id');
            $table->index('tags_id');
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
        Schema::drop('users2tags');
    }
}
