<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemBanReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_ban_report', function (Blueprint $table) {
            //
            $table->integer('id', true);
            $table->integer('user_items_id');
            $table->integer('article_id');
            $table->tinyInteger('type');
            $table->text('report_text');
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
        Schema::connection('master')->drop('item_ban_report');
    }
}
