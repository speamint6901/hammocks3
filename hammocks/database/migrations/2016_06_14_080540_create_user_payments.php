<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('master')->create('user_payments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('users_id');
            $table->integer('user_items_id');
            $table->tinyInteger('status')->default(1);
            $table->integer('price')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['users_id', 'user_items_id']);
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
        Schema::connection('master')->drop('user_payments');
    }
}
