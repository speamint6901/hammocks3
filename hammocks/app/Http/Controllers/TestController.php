<?php

namespace App\Http\Controllers;

use Mail;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{

    public function showIndex() {
        return \View::make('develop', $this->data);
    }

    public function sendMail() {
        $user = $this->user;
         Mail::send(
            'emails.confirm',
            ['user' => $user, 'token' => $user->confirmation_token],
            function($message) use ($user) {
                $message->to($user->email, $user->name)->subject('ユーザー登録確認');
            }
        );
        return redirect("develop");
    }

}
