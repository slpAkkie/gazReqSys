<?php

namespace Modules\GReqSys\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\GReqSys\Models\Model;

/**
 * @property integer|string|null $id
 * @property string $title
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Collection<Req> $reqs
 *
 * @mixin Builder
 */
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
        return $this->hasMany(Req::class, 'type_id', 'id');
    }
}
