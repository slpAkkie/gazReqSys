<?php

namespace Modules\Gaz\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Modules\Gaz\Models\Model;

/**
 * @property integer|string|null $id
 * @property string $title
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Collection<Department> $departments
 *
 * @mixin Builder
 */
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
