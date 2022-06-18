<?php

namespace Modules\Gaz\Models;

use Modules\Gaz\Models\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;

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
     * Связь: организации в городе
     *
     * @return HasMany
     */
    public function organizations()
    {
        return $this->hasMany(Organization::class, 'city_id', 'id');
    }
}
