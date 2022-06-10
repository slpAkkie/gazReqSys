<?php

namespace Modules\GReqSys\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Modules\Gaz\Models\Stuff;
use Modules\GReqSys\Models\Model;

/**
 * @property integer|string|null $id
 * @property integer|string|null $req_id
 * @property integer|string|null $gaz_stuff_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Req $req
 * @property Stuff $stuff
 *
 * @mixin Builder
 */
class InvolvedStuff extends Model
{
    /**
     * Таблица, используемая моделью.
     * Необходимо указать явно, так как иначе,
     * будет преобразовано во множественное число involved_stuffs
     *
     * @var string
     */
    protected $table = 'involved_stuff';

    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'req_id',
        'gaz_stuff_id',
    ];

    /**
     * Получить данные по сотруднику
     *
     * @return BelongsTo
     */
    public function stuff()
    {
        return $this->setConnection('gaz')->belongsTo(Stuff::class, 'gaz_stuff_id', 'id');
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
