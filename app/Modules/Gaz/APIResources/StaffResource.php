<?php

namespace Modules\Gaz\APIResources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Gaz\Models\Staff;

/**
 * @mixin Staff
 */
class StaffResource extends JsonResource
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
            $this->mergeWhen($this->showWTInfo, [
                'is_wt' => $this->wt_account()->exists(),
            ]),
        ];
    }
}
