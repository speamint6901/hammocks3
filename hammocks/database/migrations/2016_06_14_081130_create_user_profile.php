<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('master')->create('user_profile', function (Blueprint $table) {
            $table->integer('users_id');
            $table->string('avater_background_url', 255)->nullable()->default(NULL);
            $table->string('shop_avater_url', 255)->nullable()->default(NULL);
            $table->string('shop_background_url', 255)->nullable()->default(NULL);
            $table->text('user_comment')->nullable()->default(NULL);
            $table->timestamps();
            $table->softDeletes();
            $table->primary('users_id');
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
        Schema::connection('master')->drop('user_profile');
    }
}
