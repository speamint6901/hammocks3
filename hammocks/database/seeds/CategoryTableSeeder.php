<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('category')->truncate();
        $faker = Faker\Factory::create('ja_JP');

        for($i=0; $i<10; $i++) {
            \App\Models\Category::on("master")->insert(
                [
                    "name" => $faker->word(),
                    "big_category_id" => mt_rand(1, 4),
                    "created_at" => $faker->dateTime(),
                    "updated_at" => $faker->dateTime(),
                ]
            );
        }
    }
}
