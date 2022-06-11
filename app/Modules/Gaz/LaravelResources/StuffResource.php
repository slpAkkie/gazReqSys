<?php

namespace Modules\Gaz\LaravelResources;

use Illuminate\Http\Resources\Json\JsonResource;

class StuffResource extends JsonResource
{
    /**
     * Преобразование модели в API ресурс
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'second_name' => $this->second_name,
            'emp_number' => $this->emp_number,
            'email' => $this->email,
            'insurance_number' => $this->insurance_number,
        ];
    }
}
