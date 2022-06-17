<?php

namespace Modules\ReqSys\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Modules\Gaz\Models\Organization;
use Modules\Gaz\Models\Staff;
use Modules\ReqSys\Models\Model;

/**
 * @property integer|string|null $id
 * @property integer|string|null $type_id
 * @property integer|string|null $gaz_organization_id
 * @property string $status_slug
 * @property integer $author_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ReqType $type
 * @property User $author
 * @property Staff $author_staff
 * @property Collection<ReqStaff> $req_staff_records
 * @property Organization $organization
 *
 * @method Collection<Staff> getReqStaff()
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
        'gaz_organization_id',
    ];

    public function __construct(array $attributes = [])
    {
        if (key_exists('organization_id', $attributes)) {
            $attributes['gaz_organization_id'] = $attributes['organization_id'];
            unset($attributes['organization_id']);
        }

        $attributes['user_id'] = Auth::id();

        parent::__construct($attributes);
    }

    /**
     * Получить тип заявки
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
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    /**
     * Поулчить сотрудника, создавшего эту заявку
     *
     * @return BelongsTo
     */
    public function author_staff()
    {
        return $this->author->staff();
    }

    /**
     * Записи о вовлеченных сотрудниках
     *
     * @return HasMany
     */
    public function req_staff_records()
    {
        return $this->hasMany(ReqStaff::class, 'req_id', 'id');
    }

    /**
     * Сотрудники, вовлеченные в эту заявку
     *
     * @return HasMany
     */
    public function getReqStaff()
    {
        return Staff::withFired()->whereIn(
            'id',
            $this->req_staff_records->pluck('gaz_staff_id')
        )->get();
    }

    /**
     * Получить организацию в которой создана заявка
     *
     * @return BelongsTo
     */
    public function organization()
    {
        return $this->setConnection('gaz')->belongsTo(Organization::class, 'gaz_organization_id', 'id');
    }
}
