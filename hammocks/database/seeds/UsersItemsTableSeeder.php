<?php

use Illuminate\Database\Seeder;

class UsersItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('user_items')->truncate();
        $faker = Faker\Factory::create('ja_JP');
        $users = \App\Models\Users::on("master")->take(10)->get();
        $items = \App\Models\Items::on("master")->take(5)->get();
        $count = 0;
        $url = \Config::get('qpp.url');
        foreach ($users as $user) {
             $max = $items->count();
             for($i=1; $i<=$max; $i++) {
                 $count++;
                 \App\Models\User\Items::on("master")->insert(
                    [
                        "users_id" => $user->id,
                        "items_id" => $i,
                        "user_container_id" => null,
                        "store_id" => null,
                        "price" => mt_rand(1000,10000),
                        "is_store" => false,
                        "open_flag" => true,
                        "item_condition" => mt_rand(1,5),
                        "clip_count" => 0,
                        "img_url" => $url . "/user/items/".$count.".png",
                        "description" => $faker->text(),
                        "created_at" => $faker->dateTime(),
                        "updated_at" => $faker->dateTime(),
                    ]
                );
            }
        }
    }
}
