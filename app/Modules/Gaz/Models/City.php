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
 * @property Collection<Organization> $organizations
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
    public function organizations()
    {
        return $this->hasMany(Organization::class, 'city_id', 'id');
    }
}
