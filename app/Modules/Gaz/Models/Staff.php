<?php

namespace Modules\Gaz\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Modules\Gaz\Models\Model;
use Modules\Gaz\Models\Scopes\StaffScope;
use Modules\ReqSys\Models\ReqStaff;
use Modules\ReqSys\Models\Req;
use Modules\WT\Models\User as WTUser;

/**
 * @property integer|string|null $id
 * @property string $first_name
 * @property string $last_name
 * @property string $second_name
 * @property string $emp_number
 * @property string $email
 * @property string $insurance_number
 * @property integer|string|null $manager_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Collection<Organization> $organization
 * @property Collection<Post> $posts
 * @property Collection<StaffHistory> $job_meta
 * @property Collection<Req> $involved_in
 * @property WTUser $wt_account
 *
 * @mixin Builder
 */
class Staff extends Model
{
    /**
     * Используем трейт SoftDeltes
     */
    use SoftDeletes;

    /**
     * Таблица, используемая моделью.
     * Необходимо указать явно, так как иначе,
     * будет преобразовано во множественное число staffs
     *
     * @var string
     */
    protected $table = 'staff';

    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'second_name',
        // По хорошему табельный номер должен генерироваться автоматически,
        // но так как мы не делаем создание сотрудников,
        // а просто хардкодим их, то сойдет
        'emp_number',
        'email',
        'insurance_number',
    ];

    /**
     * Поулчить ФИО сотрудника
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->last_name.' '.$this->first_name.' '.$this->second_name;
    }

    /**
     * Получить пользователя в WT для этого сотрудника,
     * если аккаунт уже создан
     *
     * @return HasOne
     */
    public function wt_account()
    {
        return $this->setConnection('wt')->hasOne(WTUser::class, 'insurance_number', 'insurance_number')->withTrashed();
    }

    /**
     * Получить записи о участии в заявках
     *
     * @return BelongsTo
     */
    private function in_reqs_meta()
    {
        return $this->setConnection('reqsys')->belongsTo(ReqStaff::class, 'gaz_staff_id', 'id');
    }

    /**
     * Получить заявки, в которых он является участником
     *
     * @return Collection<Req>
     */
    public function getInReqs()
    {
        return Req::whereIn('id', $this->in_reqs_meta->pluck('req_id'))->get();
    }

    /**
     * Получить все организации, где работал сотрудник
     *
     * @return BelongsToMany
     */
    public function getOrganization()
    {
        return $this->job_meta->organization;
    }

    /**
     * Получить все должность, на которых работал сотрудник
     *
     * @return BelongsToMany
     */
    public function getPost()
    {
        return $this->job_meta->post;
    }

    /**
     * Связь: данные об устройстве
     * Последняя запись об устройстве,
     * поскольку установлен глобальный Scope
     *
     * @return HasOne
     */
    public function job_meta()
    {
        return $this->hasOne(StaffHistory::class, 'staff_id', 'id');
    }
}
