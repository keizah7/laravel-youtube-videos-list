<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Video extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function getShortDescriptionAttribute()
    {
        return Str::words($this->attributes['description'], 20);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validateVideoData(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
                'url' => 'required|unique:videos,url',
                'title' => 'required|max:255',
                'description' => 'required',
                'photo' => 'required|max:255',
        ], ['url.unique' => 'Video is already saved']);
    }
}
