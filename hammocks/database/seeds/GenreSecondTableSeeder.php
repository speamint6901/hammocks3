<?php

use Illuminate\Database\Seeder;

class GenreSecondTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('genre_second')->truncate();
        $faker = Faker\Factory::create('ja_JP');

        $genre = \App\Models\Genre::on('master')->get();
        $genre_count = $genre->count();

        for($i=0; $i<10; $i++) {
            $genre_id = mt_rand(1,$genre_count);
            $genre = \App\Models\Genre::where('id', $genre_id)->first();
            \App\Models\GenreSecond::on("master")->insert(
                [
                    "category_id" => $genre->category_id,
                    "genre_id" => $genre->id,
                    "name" => $faker->company(),
                    "created_at" => $faker->dateTime(),
                    "updated_at" => $faker->dateTime(),
                ]
            );
        }
    }
}
