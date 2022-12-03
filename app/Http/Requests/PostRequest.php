<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Validation\Rule;

class PostRequest extends BaseRequest
{
    public function __construct(Post $model)
    {
        $this->model = $model;
        $user_id = auth()->guard("api-jwt")->user()->id;
        $this->appendRules = [
            "image" => "nullable","image",
            "user_id" => "nullable", Rule::in("$user_id"),
        ];
    }
}
