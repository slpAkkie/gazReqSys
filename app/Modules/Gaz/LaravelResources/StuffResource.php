<?php

namespace Modules\Gaz\LaravelResources;

use Illuminate\Http\Resources\Json\JsonResource;

class StuffResource extends JsonResource
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
            'id' => $this->id,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'second_name' => $this->second_name,
        ];
    }
}
