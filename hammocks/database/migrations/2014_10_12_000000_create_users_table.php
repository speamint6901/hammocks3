<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('facebook_id')->nullable()->default(NULL);
            $table->bigInteger('twitter_id')->nullable()->default(NULL);
            $table->integer('sms_num')->nullable()->default(NULL);
            $table->string('name',255);
            $table->string('avater_img_url', 255)->nullable()->default(NULL);
            $table->string('email',255)->unique();
            $table->string('password',255);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('master');
        Schema::drop('users');
    }
}
