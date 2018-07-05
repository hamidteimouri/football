<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class Player extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        #return parent::toArray($request);
        return [
            'Name' => $this->first_name,
            'Family' => $this->last_name,
            'Team' => $this->team->name,
        ];
    }
}
