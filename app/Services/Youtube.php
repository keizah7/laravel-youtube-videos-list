<?php

namespace App\Services;


class Youtube
{
    private $oauthClientId, $oauthClientSecret, $youtubeApiKey, $client;

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

        $this->init();
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

        return redirect()->route('video.index');
    }

    public function isLogged()
    {
        $token = session($this->tokenKey);

        if($token) {
            $this->client->setAccessToken($token);
        }

        return $this->client->getAccessToken();
    }

    private function init(): void
    {
        $this->client = new \Google_Client();
        $this->client->setClientId($this->oauthClientId);
        $this->client->setClientSecret($this->oauthClientSecret);
        $this->client->setScopes('https://www.googleapis.com/auth/youtube');
        $this->client->setRedirectUri(route('youtube.callback'));
        $this->tokenKey = 'token-' . $this->client->prepareScopes();
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getChannels()
    {
        if($this->isLogged()) {
            try {
                $yt = new \Google_Service_YouTube($this->getClient());

                $channelsResponse = $yt->channels->listChannels('contentDetails', array(
                    'mine' => 'true',
                ));

                return collect($channelsResponse['items'])->first()->contentDetails->relatedPlaylists;
            } catch (\Google_Service_Exception | \Google_Exception $e) {
                return null;
            }
        }
    }

    public function getVideos()
    {
        return null;
    }
}
