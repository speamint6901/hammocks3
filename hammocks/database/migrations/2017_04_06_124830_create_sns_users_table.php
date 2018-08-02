<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sns_users', function (Blueprint $table) {
            //
            $table->integer('id', true);
            $table->integer('users_id');
            $table->integer('social_id');
            $table->tinyInteger('type')->nullable()->default(NULL); //1: facebook  2: twitter
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['social_id', 'type', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('master')->drop('sns_users');
    }
}
