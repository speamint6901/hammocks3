<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("master")->table('items')->truncate();
        $faker = Faker\Factory::create('ja_JP');
        $brands = \App\Models\Brands::on("master")->get();
        $max = $brands->count();
        $url = \Config::get('qpp.url');

        for($i=0; $i<30; $i++) {
            $brand_id = mt_rand(1,10);
            $brands = \App\Models\Brands::on("master")
                            ->where("brands.id", $brand_id)
                            ->first();
             \App\Models\Items::on("master")->insert(
                [
                    "category_id" => $brands->category_id,
                    "genre_id" => $brands->genre_id,
                    "genre_second_id" => $brands->genre_second_id,
                    "brands_id" => $brand_id,
                    "name" => $faker->word(),
                    "img_url" => $url . "/images/items/".$i.".jpg",
                    "img_site_url" => "http://yahoo.co.jp",
                    "clip_count" => 0,
                    "want_count" => 0,
                    "have_count" => 0,
                    "description" => $faker->text(),
                    "created_at" => $faker->dateTime(),
                    "updated_at" => $faker->dateTime(),
                ]
            );          
        }
    }
}
