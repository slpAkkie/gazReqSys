<?php

namespace Modules\Gaz\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;
use Modules\Gaz\Models\Model;
use Modules\Gaz\Models\Scopes\StaffScope;
use Modules\GReqSys\Models\InvolvedStaff;
use Modules\GReqSys\Models\Req;
use Modules\GWT\Models\User as WTUser;

/**
 * @property integer|string|null $id
 * @property string $first_name
 * @property string $last_name
 * @property string $second_name
 * @property string $emp_number
 * @property string $email
 * @property string $insurance_number
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property bool $showWTInfo
 *
 * @property Collection<Department> $departments
 * @property Collection<Post> $posts
 * @property Collection<StaffHistory> $history
 * @property Collection<Req> $involved_in
 * @property WTUser $wt_account
 *
 * @method bool isFired()
 * @method StaffHistory getLastHired()
 * @method Department getCurrentDepartment()
 * @method Post getCurrentPost()
 *
 * @mixin Builder
 */
class Staff extends Model
{
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
        'emp_number',
        'email',
        'insurance_number',
    ];

    /**
     * Индикатор отображения
     * информации об аккаунте WT для сотрудника
     *
     * @var boolean
     */
    public $showWTInfo = false;

    /**
     * Хук запуска модели
     * Устанавливаем здесь глобальный Scope
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new StaffScope);
    }

    /**
     * Запрос для поиска деактивированных сотрудников
     *
     * @return EloquentBuilder
     */
    static public function fired()
    {
        return self::withoutGlobalScope(StaffScope::class)->whereDoesntHave('job_meta');
    }

    /**
     * Запрос для поиска в том числе и деактивированных сотрудников
     *
     * @return EloquentBuilder
     */
    static public function withFired()
    {
        return self::withoutGlobalScope(StaffScope::class);
    }

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
        return !$this->job_meta()->count();
    }

    /**
     * Получить последнюю запись о найме
     *
     * @return StaffHistory|null
     */
    public function getLastHired()
    {
        return $this->job_meta()->orderBy('hired_at', 'DESC')->first();
    }

    /**
     * Получить текущую организацию в которой работает сотрудник
     *
     * @return Department|null
     */
    public function getCurrentDepartment()
    {
        return $this->departments()->first();
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
            StaffHistory::class,
            'staff_id',
            'department_id',
            'id',
            'id'
        )->using(StaffHistory::class)->withPivot([
            'hired_at',
            'post_id',
            'fired_at',
            'created_at',
            'updated_at',
        ])->as('job_meta');
    }

    /**
     * Получить текущую должность
     *
     * @return Post|null
     */
    public function getCurrentPost()
    {
        return $this->posts()->first();
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
            StaffHistory::class,
            'staff_id',
            'post_id',
            'id',
            'id'
        )->using(StaffHistory::class)->withPivot([
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
    public function wt_account()
    {
        return $this->setConnection('wt')->hasOne(WTUser::class, 'insurance_number', 'insurance_number');
    }

    private function involved_in_records()
    {
        return $this->setConnection('reqsys')->belongsTo(InvolvedStaff::class, 'gaz_staff_id', 'id');
    }

    /**
     * Получить заявки, в которые сотрудник был вовлечен
     *
     * @return HasManyThrough
     */
    public function getReqsInvolvedIn()
    {
        $ids = $this->involved_in_records->pluck('req_id');

        return Req::whereIn('id', $ids)->get();
    }

    /**
     * Получить историю приема и увольнения с работы сотрудника
     *
     * @return HasOne
     */
    public function job_meta()
    {
        return $this->hasOne(StaffHistory::class, 'staff_id', 'id');
    }
}
