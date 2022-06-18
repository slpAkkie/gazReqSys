<?php

namespace Modules\ReqSys\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\ReqSys\Models\Model;

/**
 * @property string|null $slug
 * @property string $title
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Collection<Req> $reqs
 *
 * @mixin Builder
 */
class ReqStatus extends Model
{
    /**
     * Первичный ключ для модели
     *
     * @var string
     */
    protected $primaryKey = 'slug';

    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * Преобразование колонок записи
     *
     * @var array
     */
    protected $casts = [
        'slug' => 'string',
    ];

    /**
     * Получить все заявки с этим статусом
     *
     * @return HasMany
     */
    public function reqs()
    {
        return $this->hasMany(Req::class, 'status_slug', 'slug');
    }
}
