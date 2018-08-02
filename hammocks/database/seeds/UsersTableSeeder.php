<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection("master")->table('users')->truncate();

        $faker = Faker\Factory::create('ja_JP');
        for($i=0; $i<10; $i++) {
            \App\Models\Users::on("master")->insert(
                [
                    "name" => $faker->userName(),
                    "avater_img_url" => "/images/user_default.png",
                    "email" => $faker->email(),
                    "password" => Hash::make($faker->password()),
                    "remember_token" => Hash::make($faker->password()),
                    "created_at" => $faker->dateTime(),
                    "updated_at" => $faker->dateTime(),
                ]
            );
        }
    }
}
