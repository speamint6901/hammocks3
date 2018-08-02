<?php

use Illuminate\Database\Seeder;

class UserPaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('user_payments')->truncate();
        $faker = Faker\Factory::create('ja_JP');
        $users = \App\Models\Users::on('master')->get();

        foreach ($users as $user) {
             \App\Models\User\Payments::on("master")->insert(
                [
                    "users_id" => $user->id,
                    "user_items_id" => $user->items[0]->id,
                    "status" => mt_rand(1,3),
                    "price" => mt_rand(1500,12000),
                    "created_at" => $faker->dateTime(),
                    "updated_at" => $faker->dateTime(),
                ]
            );           
        }
    }
}
