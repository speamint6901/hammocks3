<?php

use Illuminate\Database\Seeder;

class Users2TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('users2tags')->truncate();
        $faker = Faker\Factory::create('ja_JP');
        $users = \App\Models\Users::all();

        foreach ($users as $user) {
            $max = mt_rand(1, 30);
            for($i = 1; $i <= $max; $i++) {
                \App\Models\Users2Tags::on("master")->insert(
                    [
                        "users_id" => $user->id,
                        "tags_id" => $i,
                        "created_at" => $faker->dateTime(),
                        "updated_at" => $faker->dateTime(),
                    ]
                );           
            }
        }
    }
}
