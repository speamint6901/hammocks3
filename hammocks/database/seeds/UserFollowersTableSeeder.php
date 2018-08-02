<?php

use Illuminate\Database\Seeder;

class UserFollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('user_followers')->truncate();

        $users = \App\Models\Users::on('master')->get();
        $user_count = $users->count();

        $faker = Faker\Factory::create('ja_JP');
        foreach ($users as $user) {
            $max = mt_rand(2,$user_count);
            for ($i = 1; $i <= $max; $i++) {
                if ($i != $user->id) {
                    \App\Models\User\Followers::on("master")->insert(
                        [
                            "users_id" => $user->id,
                            "user_follow_id"            => $i,
                            "created_at" => $faker->dateTime(),
                            "updated_at" => $faker->dateTime(),
                        ]
                    );
                }
            }
        }
    }
}
