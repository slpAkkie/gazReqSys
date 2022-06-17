<?php

namespace Modules\ReqSys\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Modules\Gaz\Models\Staff;
use Modules\ReqSys\Models\Model;

/**
 * @property integer|string|null $id
 * @property integer|string|null $req_id
 * @property integer|string|null $gaz_staff_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Req $req
 * @property Staff $staff
 *
 * @mixin Builder
 */
class InvolvedStaff extends Model
{
    /**
     * Таблица, используемая моделью.
     * Необходимо указать явно, так как иначе,
     * будет преобразовано во множественное число involved_staffs
     *
     * @var string
     */
    protected $table = 'involved_staff';

    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'req_id',
        'gaz_staff_id',
    ];

    /**
     * Получить данные по сотруднику
     *
     * @return BelongsTo
     */
    public function staff()
    {
        return $this->setConnection('gaz')->belongsTo(Staff::class, 'gaz_staff_id', 'id')->withoutGlobalScopes();
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
