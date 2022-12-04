<?php

namespace App\Http\Resources;

use App\Models\Admin;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    public Admin $admin;
    public string $token;

    public function __construct(Admin $admin, string $token)
    {
        $this->admin = $admin;
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
            "status" => "success",
            "message" => "Admin created successfully",
            "admin" => $this->admin,
            "authorization" => [
                "token" => $this->token,
                "type" => "bearer"
            ],
        ];
    }
}
