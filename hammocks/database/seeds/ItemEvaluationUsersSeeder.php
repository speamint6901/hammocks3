<?php

use Illuminate\Database\Seeder;

class ItemEvaluationUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('item_evaluation_users')->truncate();
        $faker = Faker\Factory::create('ja_JP');
        $user_items = \App\Models\Item\Evaluation::on('master')->get();

        foreach ($user_items as $user_item) {
            for($i=1; $i<=4; $i++) { 
                 \App\Models\Item\EvaluationUsers::on("master")->insert(
                    [
                        "item_evaluation_id" => $user_item->id,
                        "users_id" => $i,
                        "evaluation_num" => mt_rand(1,5),
                        "created_at" => $faker->dateTime(),
                        "updated_at" => $faker->dateTime(),
                    ]
                );           
            }
        }
    }
}
