<?php

namespace App\Services;


class Youtube
{
    private $oauthClientId, $oauthClientSecret, $youtubeApiKey;

    /**
     * Youtube constructor.
     * @param $oauthClientId
     * @param $oauthClientSecret
     * @param $youtubeApiKey
     */
    public function __construct($oauthClientId, $oauthClientSecret, $youtubeApiKey)
    {
        $this->oauthClientId = $oauthClientId;
        $this->oauthClientSecret = $oauthClientSecret;
        $this->youtubeApiKey = $youtubeApiKey;

        $this->client = new \Google_Client();
        $this->client->setClientId($this->oauthClientId);
        $this->client->setClientSecret($this->oauthClientSecret);
        $this->client->setScopes('https://www.googleapis.com/auth/youtube');
        $this->client->setRedirectUri(route('youtube_callback'));
        $this->tokenKey = 'token-'.$this->client->prepareScopes();
    }

    public function logIn()
    {
        if(!$this->client->getAccessToken()) {
            $state = mt_rand();
            $this->client->setState($state);

            session(['state' => $state]);

            return redirect($this->client->createAuthUrl());
        }
    }

    public function auth($authCode)
    {
        $this->client->authenticate($authCode);
        session([$this->tokenKey => $this->client->getAccessToken()]);

        return redirect()->route('home');
    }

    public function isLogged()
    {
        $token = session($this->tokenKey);

        if($token) {
            $this->client->setAccessToken($token);
        }

        return $this->client->getAccessToken();
    }
}
