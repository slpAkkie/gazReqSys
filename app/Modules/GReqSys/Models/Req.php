<?php

namespace Modules\GReqSys\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Modules\Gaz\Models\Department;
use Modules\Gaz\Models\Staff;
use Modules\GReqSys\Models\Model;

/**
 * @property integer|string|null $id
 * @property integer|string|null $type_id
 * @property integer|string|null $gaz_department_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ReqType $type
 * @property User $author
 * @property Staff $staff
 * @property Collection<Staff> $involved_staff
 * @property Department $department
 *
 * @mixin Builder
 */
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

    public function __construct(array $attributes = [])
    {
        if (key_exists('department_id', $attributes)) {
            $attributes['gaz_department_id'] = $attributes['department_id'];
            unset($attributes['department_id']);
        }

        $attributes['user_id'] = Auth::id();

        parent::__construct($attributes);
    }

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
    public function staff()
    {
        return $this->author->staff();
    }

    /**
     * Сотрудники, вовлеченные в эту заявку
     *
     * @return HasMany
     */
    public function involved_staff()
    {
        return $this->setConnection('gaz')->hasMany(Staff::class, 'req_id', 'id');
    }

    /**
     * Записи о вовлеченных сотрудниках
     *
     * @return HasMany
     */
    public function involved_staff_records()
    {
        return $this->hasMany(InvolvedStaff::class, 'req_id', 'id');
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
