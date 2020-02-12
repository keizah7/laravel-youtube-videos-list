<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Video extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => 'https://www.youtube.com/watch?v='.$this->url,
            'title' => $this->title,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'photo' => $this->photo,
            'user' => $this->user,
            'created_at' => $this->created_at,
        ];
//        return parent::toArray($request);
    }
}
