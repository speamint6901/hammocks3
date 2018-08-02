<?php

use Illuminate\Database\Seeder;

class UserItem2TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('user_item2tags')->truncate();
        $faker = Faker\Factory::create('ja_JP');
        $user_items = \App\Models\User\Items::all();

        foreach ($user_items as $user_item) {
            $max = mt_rand(1, 30);
            for($i = 1; $i <= $max; $i++) {
                \App\Models\User\Item2Tags::on("master")->insert(
                    [
                        "user_items_id" => $user_item->id,
                        "tags_id" => $i,
                        "created_at" => $faker->dateTime(),
                        "updated_at" => $faker->dateTime(),
                    ]
                );           
            }
        }
    }
}
