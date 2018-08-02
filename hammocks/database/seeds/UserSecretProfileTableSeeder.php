<?php

use Illuminate\Database\Seeder;

class UserSecretProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('user_secret_profile')->truncate();
        $faker = Faker\Factory::create('ja_JP');
        $users = \App\Models\Users::on('master')->take(7)->get();

        foreach ($users as $user) {
             \App\Models\User\SecretProfile::on("master")->insert(
                [
                    "users_id" => $user->id,
                    "phone" => $faker->phoneNumber(),
                    "prefecture_id" => mt_rand(1,47),
                    "city" => $faker->city(),
                    "address" => $faker->address(),
                    "post_code" => "3330125", 
                    "created_at" => $faker->dateTime(),
                    "updated_at" => $faker->dateTime(),
                ]
            );           
        }
    }
}
