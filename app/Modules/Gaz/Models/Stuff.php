<?php

namespace Modules\Gaz\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;
use Modules\Gaz\Models\Model;
use Modules\GReqSys\Models\InvolvedStuff;
use Modules\GReqSys\Models\Req;
use Modules\GWT\Models\User as WTUser;

/**
 * TODO: Валидировать ввденный снилс регулярным выражением (Формат снилса: 000-000-000 00)
 *
 * @property integer|string|null $id
 * @property string $first_name
 * @property string $last_name
 * @property string $second_name
 * @property string $emp_number
 * @property string $email
 * @property string $insurance_number
 * @property bool $diativated
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property bool $showWTInfo
 *
 * @property Collection<Department> $departments
 * @property Collection<Post> $posts
 * @property Collection<StuffHistory> $history
 * @property Collection<Req> $involved_in
 * @property WTUser $wt_user
 *
 * @method bool isFired()
 * @method StuffHistory getLastHired()
 * @method Department getCurrentDepartment()
 * @method Post getCurrentPost()
 *
 * @mixin Builder
 */
class Stuff extends Model
{
    /**
     * Таблица, используемая моделью.
     * Необходимо указать явно, так как иначе,
     * будет преобразовано во множественное число stuffs
     *
     * @var string
     */
    protected $table = 'stuff';

    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'second_name',
        'emp_number',
        'email',
        'insurance_number',
    ];

    public $showWTInfo = false;

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
     * Проверить уволен ли сотрудник
     *
     * @return boolean
     */
    public function isFired()
    {
        return !!$this->history()->whereNull('fired_at')->first();
    }

    /**
     * Получить последнюю запись о найме
     *
     * @return StuffHistory|null
     */
    public function getLastHired()
    {
        return $this->history()->orderBy('hired_at', 'DESC')->first();
    }

    /**
     * Получить текущую организацию в которой работает сотрудник
     *
     * @return Department|null
     */
    public function getCurrentDepartment()
    {
        return $this->departments()->wherePivotNotNull('fired_at')->first();
    }

    /**
     * Получить все организации, где работал сотрудник
     *
     * @return BelongsToMany
     */
    public function departments()
    {
        return $this->belongsToMany(
            Department::class,
            StuffHistory::class,
            'stuff_id',
            'department_id',
            'id',
            'id'
        )->using(StuffHistory::class)->withPivot([
            'hired_at',
            'post_id',
            'fired_at',
            'created_at',
            'updated_at',
        ])->as('job_info');
    }

    /**
     * Получить текущую должность
     *
     * @return Post|null
     */
    public function getCurrentPost()
    {
        return $this->posts()->wherePivotNotNull('fired_at')->first();
    }

    /**
     * Получить все должность, на которых работал сотрудник
     *
     * @return BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(
            Post::class,
            StuffHistory::class,
            'stuff_id',
            'post_id',
            'id',
            'id'
        )->using(StuffHistory::class)->withPivot([
            'hired_at',
            'department_id',
            'fired_at',
            'created_at',
            'updated_at',
        ])->as('job_info');
    }

    /**
     * Получить пользователя в WT для этого сотрудника,
     * если аккаунт уже создан
     *
     * @return HasOne
     */
    public function wt_user()
    {
        return $this->setConnection('wt')->hasOne(WTUser::class, 'insurance_number', 'insurance_number');
    }

    /**
     * Получить заявки, в которые сотрудник был вовлечен
     *
     * @return HasManyThrough
     */
    public function involved_in()
    {
        // TODO: Получить записи из БД GReqSys о заявках, в которые сотрудник был вовлечен
        return $this->setConnection('reqsys')->hasManyThrough(
            Req::class,
            InvolvedStuff::class,
            'gaz_stuff_id',
            'id',
            'id',
            'req_id',
        );
    }

    /**
     * Получить историю приема и увольнения с работы сотрудника
     *
     * @return HasMany
     */
    public function history()
    {
        return $this->hasMany(StuffHistory::class, 'stuff_id', 'id');
    }
}
