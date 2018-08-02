<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User\Follow as UserFollow;
use App\Models\User\Followers as UserFollowers;

class UserFollowJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $target_user_id;
    protected $follower_user_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        //
        $this->target_user_id = $params['target_user_id'];
        $this->follower_user_id = $params['follower_user_id'];
    }

    /**
     * Execute the job.
     * フォロワーのカウントアップ処理
     *
     * @return void
     */
    public function handle()
    {
        //
        $follow_with_followers = UserFollow::with('followers')->where('users_id', $this->target_user_id)->first();
        $deplicate_follower = null;
        if (isset($follow_with_followers->followers)) {
            $deplicate_follower = $follow_with_followers->followers->where('user_follow_id', $this->follower_user_id)->first();
        }
        // insert
        if (is_null($deplicate_follower) || $deplicate_follower->count() == 0) {
            UserFollowers::insert(["users_id" => $this->target_user_id, "user_follow_id" => $this->follower_user_id]);
            $follow_with_followers->increment('user_follower_count', 1);
        }
        return $follow_with_followers->user_follower_count;
    }
}
