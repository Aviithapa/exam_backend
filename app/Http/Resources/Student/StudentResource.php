<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"      => $this->id,
            "name"    => $this->name,
            "date_of_birth"  => $this->date_of_birth,
            "symbol_number" => $this->symbol_number,
            "photo" => $this->photo,
            "subject" => $this->subject,
            "administrator" => $this->administrator,
            "phone_number" => $this->phone_number,
        ];
    }
}
