<?php

namespace App\Http\Resources\User;

use App\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;
// use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // dd($this);
        return [
            "id"      => $this->id,
            "name"    => $this->name,
            "email"  => $this->email,
            "phone_number" => $this->phone_number,
            "role" => $this->roles,
            "status" => "success",
            'authorisation' => [
                'token' => $this->token,
                'type' => 'bearer',
            ]
        ];
    }
}
