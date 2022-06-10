<?php

namespace Modules\GReqSys\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\GReqSys\Models\Model;

class ReqType extends Model
{
    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * Получить все заявки этого типа
     *
     * @return HasMany
     */
    public function reqs()
    {
        return $this->hasMany(Req::class, 'req_type_id', 'id');
    }
}
