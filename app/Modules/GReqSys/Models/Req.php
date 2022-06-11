<?php

namespace Modules\GReqSys\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Modules\Gaz\Models\Department;
use Modules\Gaz\Models\Stuff;
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
 * @property Stuff $stuff
 * @property Collection<Stuff> $involved_stuff
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
    public function stuff()
    {
        return $this->author->stuff();
    }

    /**
     * Сотрудники, вовлеченные в эту заявку
     *
     * @return HasMany
     */
    public function involved_stuff()
    {
        return $this->setConnection('gaz')->hasMany(Stuff::class, 'req_id', 'id');
    }

    /**
     * Записи о вовлеченных сотрудниках
     *
     * @return HasMany
     */
    public function involved_stuff_records()
    {
        return $this->hasMany(InvolvedStuff::class, 'req_id', 'id');
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
