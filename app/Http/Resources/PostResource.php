<?php

namespace App\Http\Resources;

use App\Models\Post;
class PostResource extends BaseResource
{
    protected Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
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
            "status" => "success",
            "id" => $this->post->id,
            "title" => $this->post->title,
            "body" => $this->post->body,
        ];
    }
}
