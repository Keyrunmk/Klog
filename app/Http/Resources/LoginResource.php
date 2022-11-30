<?php

namespace App\Http\Resources;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    public User|Admin $model;
    public string $token;

    public function __construct(User|Admin $model, string $token)
    {
        $this->model = $model;
        $this->token = $token;
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
            'status' => 'success',
            'model' => $this->model,
            'authorization' => [
                'token' => $this->token,
                'type' => 'bearer'
            ],
        ];
    }
}
