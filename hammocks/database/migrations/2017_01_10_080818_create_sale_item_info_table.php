<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleItemInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_item_info', function (Blueprint $table) {
            //
            $table->integer('id', true);
            $table->integer('user_items_id');
            $table->tinyInteger('payment_conditon_id'); // 販売ステータス（payment_conditionマスタと1:1)
            $table->integer('prefecture_id');  //発送元都道府県
            $table->integer('delivery_company_id'); //宅配業者
            $table->tinyInteger('delivery_pattern')->default(0);  // 配送料負担(0:着払い 1:送料込み)
            $table->tinyInteger('delivery_day_nums');  // 配送日数(1:1-2日 2:2-3日 3:3-7日など)
            $table->timestamps();
            $table->softDeletes();
            $table->unique('user_items_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sale_item_info');
    }
}
