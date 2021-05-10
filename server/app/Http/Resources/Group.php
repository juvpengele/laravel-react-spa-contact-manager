<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Group extends JsonResource
{

    public function toArray($request)
    {
        return [
            "name" => $this->name,
            "description" => $this->description,
            "image" => $this->image()->url,
            "user_id" => $this->user_id
        ];
    }
}
