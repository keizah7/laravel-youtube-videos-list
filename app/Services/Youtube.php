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

    /**
     * Initializes class variables
     */
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

    /**
     * Redirects user to OAUTH login
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logIn()
    {
        if (!$this->client->getAccessToken()) {
            $state = mt_rand();
            $this->client->setState($state);

            session(['state' => $state]);

            return redirect($this->client->createAuthUrl());
        }
    }

    /**
     * Authenticates user after callback
     *
     * @param $authCode
     * @return \Illuminate\Http\RedirectResponse
     */
    public function auth($authCode)
    {
        $this->client->authenticate($authCode);
        session([$this->tokenKey => $this->client->getAccessToken()]);

        return redirect()->route('youtube.index');
    }

    /**
     * Authenticates user
     *
     * @return mixed user access token
     */
    public function isLogged()
    {
        $token = session($this->tokenKey);

        if ($token) {
            $this->client->setAccessToken($token);
        }

        return $this->client->getAccessToken();
    }

    /**
     * Gets user channels and playlists
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function getChannels()
    {
        if ($this->isLogged()) {
            try {
                $yt = new \Google_Service_YouTube($this->getClient());

                $channelsResponse = $yt->channels->listChannels('snippet, contentDetails', ['mine' => true]);
                $channels = collect($channelsResponse)->first()->contentDetails->relatedPlaylists;

                $channels = collect($channels)->filter(function ($value) {
                    return $value;
                });

                return $this->channels = $this->getPlaylists($yt)->merge($channels);
            } catch (\Google_Service_Exception | \Google_Exception $e) {
                return null;
            }
        }
    }

    /**
     * Gets user videos by channel and current page
     *
     * @param $channelId
     * @param $page
     * @return \Google_Service_YouTube_PlaylistItemListResponse|\Illuminate\Support\Collection|null
     */
    public function getVideos($channelId, $page)
    {
        if ($this->isLogged()) {
            try {
                $yt = new \Google_Service_YouTube($this->getClient());

                $videos = $yt->playlistItems->listPlaylistItems('snippet', [
                    'playlistId' => $channelId ?? $this->channels->first(),
                    'maxResults' => 10,
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

    /**
     * Gets user video by id
     *
     * @param $id
     * @return \Illuminate\Support\Collection|mixed
     */
    public function getVideo($id)
    {
        if ($this->isLogged()) {
            try {
                $yt = new \Google_Service_YouTube($this->getClient());

                return collect($yt->videos->listVideos('snippet', [
                    'id' => $id
                ])->items)->first();
            } catch (\Google_Service_Exception | \Google_Exception $e) {
                return collect();
            }
        }

        return collect();
    }

    /**
     * Gets user playlists
     *
     * @param \Google_Service_YouTube $yt
     * @return \Illuminate\Support\Collection|mixed
     */
    private function getPlaylists(\Google_Service_YouTube $yt)
    {
        $playlists = $yt->playlists->listPlaylists('snippet', ['mine' => true])->items;

        return collect($playlists)->mapWithKeys(function ($item) {
            return [$item->snippet->title => $item->id];
        });
    }

    /**
     * Gets videos pagination info
     *
     * @return mixed
     */
    public function getPagesInfo()
    {
        return $this->pagesInfo ?? null;
    }

    public function getClient()
    {
        return $this->client;
    }
}
