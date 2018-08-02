<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User\InfoCount as UserInfoCount;
use App\Models\User\ItemStatus as UserItemStatus;

class HaveWantCountUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'have_want_count:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        // １００件ずつ処理する
        UserInfoCount::chunk(100, function($user_info_counts) {
            foreach ($user_info_counts as $user_info_count) {
                $user_info_count->have_count = self::getStatusCount($user_info_count->users_id, 1);
                $user_info_count->want_count = self::getStatusCount($user_info_count->users_id, 2);
                $user_info_count->save();
            }
        });
    }

    /**
    * ユーザーごとのhave or wantのカウントを取得する
    *
    * @params  $type  int  have or want
    * @return int カウント
    */
    public static function getStatusCount($users_id, $type) {
        return UserItemStatus::on('master')
                  ->where('users_id', $users_id)
                  ->where('status', $type)
                  ->count(); 
    }
}
