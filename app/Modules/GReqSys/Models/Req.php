<?php

namespace Modules\GReqSys\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Gaz\Models\Department;
use Modules\Gaz\Models\Stuff;
use Modules\GReqSys\Models\Model;

class Req extends Model
{
    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'type_id',
        'user_id',
        'gaz_department_id',
    ];

    /**
     * Получить типа заявки
     *
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ReqType::class, 'type_id', 'id');
    }

    /**
     * Получить пользователя, создавшего заявку
     *
     * @return BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Поулчить сотрудника, создавшего эту заявку
     *
     * @return BelongsTo
     */
    public function stuff()
    {
        return $this->author->stuff();
    }

    /**
     * Получить организацию в которой создана заявка
     *
     * @return BelongsTo
     */
    public function department()
    {
        return $this->setConnection('gaz')->belongsTo(Department::class, 'gaz_department_id', 'id');
    }
}
