<?php

use Illuminate\Database\Seeder;

class UserItemImgsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('user_item_imgs')->truncate();

        $user_items = \App\Models\User\Items::on('master')->get();

        $faker = Faker\Factory::create('ja_JP');
        foreach ($user_items as $user_item) {
            \App\Models\User\ItemImgs::on("master")->insert(
                [
                    "users_items_id" => $user_item->id,
                    "img_url" => "http://hammocks-product.com/img/user/item/".$user_item->id.".png",
                ]
            );
        }
    }
}
