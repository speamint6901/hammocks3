<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        //$this->call(UserProfileTableSeeder::class);
        //$this->call(UserSecretProfileTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(GenreTableSeeder::class);
        $this->call(GenreSecondTableSeeder::class);
        $this->call(BrandsTableSeeder::class);
//        $this->call(ItemsTableSeeder::class);
//        $this->call(UsersItemsTableSeeder::class);
//        $this->call(UserItemImgsTableSeeder::class);
//        $this->call(UserPaymentsTableSeeder::class);
//        $this->call(ItemEvaluationSeeder::class);
//        $this->call(ItemEvaluationUsersSeeder::class);
        //$this->call(UserFollowersTableSeeder::class);       
        //$this->call(UserFollowTableSeeder::class);
//        $this->call(TagsTableSeeder::class);
//        $this->call(Users2TagsTableSeeder::class);
//        $this->call(UserItem2TagsTableSeeder::class);
        //$this->call(UserItemNeedUsersTableSeeder::class);
    }
}
