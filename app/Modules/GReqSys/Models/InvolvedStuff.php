<?php

namespace Modules\GReqSys\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\GReqSys\Models\Model;

class InvolvedStuff extends Model
{
    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'req_id',
        'gaz_stuff_id',
    ];

    public function stuff()
    {
        // TODO: Получить сотрудника из БД Gaz
    }

    /**
     * Поулчить заявку, в которую он был вовлечен (Текущая завяка для этой записи вовлеченности)
     *
     * @return BelongsTo
     */
    public function req()
    {
        return $this->belongsTo(Req::class, 'req_id', 'id');
    }
}
