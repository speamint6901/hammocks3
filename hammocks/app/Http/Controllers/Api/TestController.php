<?php

namespace App\Http\Controllers\Api;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{

    public function showIndex() {
        return new JsonResponse(
            ["result" => 
                ["0" =>
                    [
                        'itemName' => 'test item name1',
                        'brandName' => "brand test1",
                        'itemImg'  =>  "http://hanmmocks.com/images/itemImg1.jpg",
                        'clipCount' => "30",
                        'needCount' => "120",
                        'favCount' => "200",
                        'price'    => "12000",
                    ],
                    [
                        'itemName' => 'test item name2',
                        'brandName' => "brand test2",
                        'itemImg'  =>  "http://hanmmocks.com/images/itemImg2.jpg",
                        'clipCount' => "40",
                        'needCount' => "320",
                        'favCount' => "100",
                        'price'    => "32400",
                    ]
                ]
            ]
        );
    }

    public function getTitle() {

        return new JsonResponse(
            ["title" => "hammocks top"]
        );

    }

}
