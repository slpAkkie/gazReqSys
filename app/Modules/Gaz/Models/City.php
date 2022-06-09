<?php

namespace Modules\Gaz\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Gaz\Models\Model;

class City extends Model
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
     * Получить организации в этом городе
     *
     * @return HasMany
     */
    public function departments()
    {
        return $this->hasMany(Department::class, 'city_id', 'id');
    }
}
