<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('users_id');
            $table->integer('items_id');
            $table->integer('user_container_id')->nullable()->default(NULL);
            $table->integer('store_id')->nullable()->default(NULL);
            $table->tinyInteger('status')->default(0); //公開ステータス(0:非公開 1:公開)
            $table->integer('price')->default(0);
            $table->string('img_url',100)->nullable();
            $table->string('img_site_url',100)->nullable()->default(NULL);
            $table->tinyInteger('item_condition')->default(0);
            $table->text('description')->nullable()->default(NULL);
            $table->tinyInteger('is_store')->default(0);
            $table->tinyInteger('open_flag')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index('user_container_id');
            $table->index('items_id');
            $table->index('users_id');
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
        Schema::connection('master')->drop('user_items');
    }
}
