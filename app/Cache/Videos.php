<?php

namespace App\Cache;

use App\Video;
use Carbon\Carbon;

class Videos
{
    const CACHE_KEY = 'USERS.';

    public function all($orderBy, $inPage)
    {
        $lastVideoId = Video::latest()->first()->id ?? 0;
        $key = "all.{$orderBy}{$lastVideoId}";
        $cacheKey = $this->getCacheKey($key);

        return cache()->remember($cacheKey, Carbon::now()->addMinutes(30), function () use ($orderBy, $inPage) {
            return Video::with([
                'user' => function ($q) {
                    $q->select(['id', 'name']);
                }
            ])->orderByDesc($orderBy)->paginate($inPage);
        });
    }

    private function getCacheKey($key)
    {
        return self::CACHE_KEY . strtoupper($key);
    }
}
