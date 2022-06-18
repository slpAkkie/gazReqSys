<?php

namespace Modules\Gaz\Models;

use Modules\Gaz\Models\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Modules\ReqSys\Models\Req;

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
class Organization extends Model
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
     * Связь: город, в котором находится организация
     *
     * @return BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    /**
     * Связь: сотрудники организации
     *
     * @return BelongsToMany
     */
    public function staff()
    {
        return Staff::leftJoin(
            'staff_history',
            'staff_history.staff_id', 'staff.id'
        )->whereNull('staff_history.fired_at')
        ->where('staff_history.organization_id', $this->id)->with('job_meta');
    }

    /**
     * Связь: заявки созданные в организации
     *
     * @return HasMany
     */
    public function reqs()
    {
        return $this->setConnection('reqsys')->hasMany(Req::class, 'gaz_organization_id', 'id');
    }
}
