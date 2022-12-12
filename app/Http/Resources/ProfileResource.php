<?php

namespace App\Http\Resources;

use App\Models\Profile;
class ProfileResource extends BaseResource
{
    protected Profile $profile;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->profile->id,
            "title" => $this->profile->title,
            "description" => $this->profile->description,
            "url" => $this->profile->url,
        ];
    }
}
