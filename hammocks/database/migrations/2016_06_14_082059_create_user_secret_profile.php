<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSecretProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_secret_profile', function (Blueprint $table) {
            $table->integer('users_id');
            $table->tinyInteger('is_sms_auth')->default(0);
            $table->tinyInteger('is_certificate_auth')->default(0);
            $table->string('name', 80)->nullable()->default(NULL);;
            $table->string('name_kana', 80)->nullable()->default(NULL);;
            $table->string('phone', 15)->nullable()->default(NULL);;
            $table->tinyInteger('prefecture_id')->nullable()->default(NULL);;
            $table->string('city')->nullable()->default(NULL);
            $table->text('address')->nullable()->default(NULL);
            $table->string('post_code', 7)->nullable()->default(NULL);
            $table->smallInteger('birth_year')->nullable()->default(NULL);
            $table->tinyInteger('birth_mon')->nullable()->default(NULL);
            $table->tinyInteger('birth_day')->nullable()->default(NULL);
            $table->string('bank_name')->nullable()->default(NULL);
            $table->tinyInteger('bank_account_type')->nullable()->default(NULL);
            $table->integer('bank_account_num')->nullable()->default(NULL);
            $table->string('bank_account_name')->nullable()->default(NULL);
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
        Schema::connection('master')->drop('user_secret_profile');
    }
}
