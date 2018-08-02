<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Profile extends \App\Models\Base 
{
    protected $table = "user_profile";

    public $incrementing = false;
    protected $primaryKey = 'users_id';
}
