<?php

use Illuminate\Database\Seeder;

class GenreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('genre')->truncate();
        $faker = Faker\Factory::create('ja_JP');

        $categorys = \App\Models\Category::on('master')->get();
        $category_count = $categorys->count();

        for($i=0; $i<10; $i++) {
            \App\Models\Genre::on("master")->insert(
                [
                    "category_id" => mt_rand(1,$category_count),
                    "name" => $faker->company(),
                    "created_at" => $faker->dateTime(),
                    "updated_at" => $faker->dateTime(),
                ]
            );
        }
    }
}
