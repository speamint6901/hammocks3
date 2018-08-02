<?php

use Illuminate\Database\Seeder;

class UserFollowTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('user_follow')->truncate();

        $users = \App\Models\Users::on('master')->get();

        $faker = Faker\Factory::create('ja_JP');
        foreach ($users as $user) {
            $follower_count = \App\Models\User\Followers::on("master")->where('users_id', $user->id)->get()->count();
            \App\Models\User\Follow::on("master")->insert(
                [
                    "users_id" => $user->id,
                    "user_follower_count" => $follower_count,
                    "created_at" => $faker->dateTime(),
                    "updated_at" => $faker->dateTime(),
                ]
            );
        }
    }
}
