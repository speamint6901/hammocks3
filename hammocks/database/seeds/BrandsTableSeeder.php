<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('brands')->truncate();

        $faker = Faker\Factory::create('ja_JP');

        for($i=0; $i<10; $i++) {
            \App\Models\Brands::on("master")->insert(
                [
                    "name" => $faker->company(),
                    "brand_img_url" => $faker->url(),
                    "name_hiragana" => $faker->colorName(),
                    "name_katakana" => $faker->colorName(),
                    "name_japan" => $faker->colorName(),
                    "name_display" => $faker->colorName(),
                    "created_at" => $faker->dateTime(),
                    "updated_at" => $faker->dateTime(),
                ]
            );
        }
    }
}
