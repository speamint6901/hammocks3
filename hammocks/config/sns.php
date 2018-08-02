<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication facebook
    |--------------------------------------------------------------------------
    */
    'facebook' => [
        'app_id' => env('FACEBOOK_APP_ID'), 
        'secret_key' => env('FACEBOOK_SECRET_KEY'),
        'auth_redirect_uri' => env('FACEBOOK_AUTH_URI'),
        'token_check_uri' => env('FACEBOOK_TOKEN_CHECK_URI')
    ],

    'sharLink' => [
        'facebook' => [
            'url' => 'https://www.facebook.com/sharer/sharer.php?u=',
            'text_key' => 't',
            'text' => 'facebook test',
        ],
        'twitter' => [
            'url' => 'https://twitter.com/share?shareUrl=',
            'text_key' => 'text',
            'text' => 'twitter test',
        ],
        'google' => [
            'url' => 'https://plus.google.com/share?shareUrl=',
            'text_key' => '',
            'text' => 'google test',
        ],
        'pinterest' => [
            'url' => 'http://pinterest.com/pin/create/button/?url=',
            'text_key' => 'description',
            'text' => 'pinterest test',
        ],
    ],
];
