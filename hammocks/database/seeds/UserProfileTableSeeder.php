<?php

use Illuminate\Database\Seeder;

class UserProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('user_profile')->truncate();
        $faker = Faker\Factory::create('ja_JP');
        $users = \App\Models\Users::on('master')->get();

        foreach ($users as $user) {
             \App\Models\User\Profile::on("master")->insert(
                [
                    "users_id" => $user->id,
                    "avater_background_url" => "http://hammocks-img/user/avater/background/".$user->id.".png",
                    "shop_avater_url" => "http://hammocks-img/shop/avater/icon/".$user->id.".png",
                    "shop_background_url" => "http://hammocks-img/shop/avater/background/".$user->id.".png",
                    "user_comment" => $faker->text(),
                    "birth_year" => mt_rand(1950,2000),
                    "birth_mon" => mt_rand(1,12),
                    "birth_day" => mt_rand(1,28),
                    "created_at" => $faker->dateTime(),
                    "updated_at" => $faker->dateTime(),
                ]
            );           
        }

    }
}
