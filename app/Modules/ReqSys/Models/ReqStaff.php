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
 * @property string|null $accepted
 * @property string|null $refusal_reason
 * @property integer $updated_at
 * @property integer $created_at
 *
 * @property Req $req
 * @property Staff $staff
 *
 * @mixin Builder
 */
class ReqStaff extends Model
{
    /**
     * Таблица, используемая моделью.
     * Необходимо указать явно, так как иначе,
     * будет преобразовано во множественное число req_staffs
     *
     * @var string
     */
    protected $table = 'req_staff';

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
     * Связь: сотрудник
     *
     * @return BelongsTo
     */
    public function staff()
    {
        // Отключаем глобальный Scope для модели сотрудника
        // чтобы получить информацию,
        // даже если его учетная запись отключена
        return $this->setConnection('gaz')->belongsTo(Staff::class, 'gaz_staff_id', 'id')->withoutGlobalScopes();
    }

    /**
     * Связь: заявка
     *
     * @return BelongsTo
     */
    public function req()
    {
        return $this->belongsTo(Req::class, 'req_id', 'id');
    }
}
