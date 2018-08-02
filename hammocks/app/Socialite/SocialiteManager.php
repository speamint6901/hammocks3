<?php

namespace App\Socialite;


class SocialiteManager extends \Laravel\Socialite\SocialiteManager {

    protected function createFacebookDriver()
    {
        $config = $this->app['config']['services.facebook'];

        return $this->buildProvider(
            'App\Socialite\FacebookProvider',$config
        );
    }
}
