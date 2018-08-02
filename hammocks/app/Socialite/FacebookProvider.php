<?php

namespace App\Socialite;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class FacebookProvider extends AbstractProvider implements ProviderInterface
{
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://www.facebook.com/v2.8/dialog/oauth', $state);
    }

    protected function getTokenUrl()
    {
        return "https://graph.facebook.com/v2.8/oauth/access_token";
    }

    public function getAccessToken($code)
    {
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $this->redirectUrl,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret
            ],
        ]);
        return $this->parseAccessToken($response->getBody());
    }

    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://graph.facebook.com/v2.8/me?fields=id,name,picture{url}&access_token='.$token, [
            'headers' => [
                'access_token' => $token,
            ],
        ]);
        return json_decode($response->getBody(), true);
    }

    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['id'],
            'name' => $user['name'],
            'avatar_original' => $user['picture']['data']['url'],
        ]);
    }

    protected function parseAccessToken($body)
    {
        return json_decode($body, true);
    }
}
