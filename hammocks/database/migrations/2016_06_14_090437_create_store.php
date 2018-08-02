<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('master')->create('store', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('users_id');
            $table->string('name',255);
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
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
        //
        Schema::connection('master')->drop('store');
    }
}
