<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Items as Item;
use App\Models\User\ItemNeedUsers as ItemNeed;
use App\Models\User\ItemHasUsers as ItemHas;

class HasWantUsersJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    const COUNT_TYPE_WANT = 1;
    const COUNT_TYPE_HAS = 2;

    const COUNT_UPDATE_TYPE_ADD = 1;
    const COUNT_UPDATE_TYPE_SUB = 1;

    protected $count_type; // 1:want  2:has
    protected $item_id;
    protected $users_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        //
        $this->count_type = $params['type'];
        $this->item_id = $params['item_id'];
        $this->users_id = $params['users_id'];
    }

    /**
     * Execute the job.
     * ほしい、持ってるカウントの更新、切り替え
     *
     * @return \App\Models\Items
     */
    public function handle()
    {
        //

    }


}
