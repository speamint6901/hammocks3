<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('tags')->truncate();
        $faker = Faker\Factory::create('ja_JP');

        for($i = 1; $i <= 30; $i++) {
            \App\Models\Tags::on("master")->insert(
                [
                    "tag_text" => $faker->word(),
                    "created_at" => $faker->dateTime(),
                    "updated_at" => $faker->dateTime(),
                ]
            );           
        }
    }
}
