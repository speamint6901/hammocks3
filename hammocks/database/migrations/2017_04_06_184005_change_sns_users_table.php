<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSnsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sns_users', function (Blueprint $table) {
            //
            $table->bigInteger('social_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sns_users', function (Blueprint $table) {
            //
            $table->integer('social_id')->change();
        });
    }
}
