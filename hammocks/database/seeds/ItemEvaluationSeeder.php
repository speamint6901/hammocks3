<?php

use Illuminate\Database\Seeder;

class ItemEvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('item_evaluation')->truncate();
        $faker = Faker\Factory::create('ja_JP');
        $user_items = \App\Models\Items::on('master')->take(30)->get();

        foreach ($user_items as $user_item) {
             \App\Models\Item\Evaluation::on("master")->insert(
                [
                    "items_id" => $user_item->id,
                    "average" => mt_rand(1,5),
                    "created_at" => $faker->dateTime(),
                    "updated_at" => $faker->dateTime(),
                ]
            );           
        }
    }
}
