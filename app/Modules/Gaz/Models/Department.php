<?php

namespace Modules\Gaz\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Gaz\Models\Model;

class Department extends Model
{
    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'city_id',
    ];

    /**
     * Получить город, в котром расположена организация
     *
     * @return BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function stuff()
    {
        // TODO: Получить сотрудников этой организации через таблицу stuff_history
    }

    public function reqs()
    {
        // TODO: Получить все заявки организации
    }
}
