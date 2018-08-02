<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsHasCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands_has_count', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('brands_id');
            $table->integer('count');
            $table->timestamps();
            $table->softDeletes();
            $table->index('brands_id');
            $table->index(['brands_id', 'count']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('brands_has_count');
    }
}
