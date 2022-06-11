<?php

namespace Modules\Gaz\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Modules\Gaz\Models\Model;
use Modules\GReqSys\Models\Req;

/**
 * @property integer|string|null $id
 * @property string $title
 * @property integer|string|null $city_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property City $city
 * @property Collection<Staff> $staff
 * @property Collection<Req> $reqs
 *
 * @mixin Builder
 */
class Department extends Model
{
    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'city_id',
    ];

    /**
     * Получить город, в котром расположена организация
     *
     * @return BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    /**
     * Получить сотрудников этой организации
     *
     * @return BelongsToMany
     */
    public function staff()
    {
        return $this->belongsToMany(
            Staff::class,
            StaffHistory::class,
            'department_id',
            'staff_id',
            'id',
            'id',
        )->using(StaffHistory::class)->withPivot(
            'hired_at',
            'post_id',
            'fired_at',
            'created_at',
            'updated_at',
        )->as('job_info');
    }

    /**
     * Получить все заявки внутри организации
     *
     * @return HasMany
     */
    public function reqs()
    {
        return $this->setConnection('reqsys')->hasMany(Req::class, 'gaz_department_id', 'id');
    }
}
