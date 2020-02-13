<?php

namespace App\Services;


class Youtube
{
    private $oauthClientId, $oauthClientSecret, $youtubeApiKey, $client, $pagesInfo;

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

        return redirect()->route('youtube.index');
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
        $this->channels = collect();
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

                $channelsResponse = $yt->channels->listChannels('snippet, contentDetails', ['mine' => true]);
                $channels = collect($channelsResponse)->first()->contentDetails->relatedPlaylists;

                $channels = collect($channels)->filter(function ($value) {
                    return $value;
                });

                $playlists = $yt->playlists->listPlaylists('snippet', ['mine' => true])->items;
                $playlists = collect($playlists)->mapWithKeys(function ($item) {
                    return [$item->snippet->title => $item->id];
                });

                return $this->channels = $playlists->merge($channels);
            } catch (\Google_Service_Exception | \Google_Exception $e) {
                return null;
            }
        }
    }

    public function getVideos($channelId, $page)
    {
        if($this->isLogged()) {
            try {
                $yt = new \Google_Service_YouTube($this->getClient());

                $videos = $yt->playlistItems->listPlaylistItems('snippet', [
                    'playlistId' => $channelId ?? $this->channels->first(),
                    'maxResults' => 5,
                    'pageToken' => $page,
                ]);

                $this->pagesInfo = [
                    'next' => $videos->nextPageToken,
                    'prev' => $videos->prevPageToken,
                    'total' => $videos->pageInfo->totalResults,
                    'inPage' => $videos->pageInfo->resultsPerPage,
                ];

                return $videos;
            } catch (\Google_Service_Exception | \Google_Exception $e) {
                return null;
            }
        }

        return collect();
    }

    public function getVideo($id)
    {
        if($this->isLogged()) {
            try {
                $yt = new \Google_Service_YouTube($this->getClient());

                return collect($yt->videos->listVideos('snippet', [
                    'id' => $id,
                ])->items)->first();
            } catch (\Google_Service_Exception | \Google_Exception $e) {
                return collect();
            }
        }

        return collect();
    }

    /**
     * @return mixed
     */
    public function getPagesInfo()
    {
        return $this->pagesInfo ?? null;
    }
}
