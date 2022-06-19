<?php

namespace Modules\ReqSys\Models;

use Modules\ReqSys\Models\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Modules\Gaz\Models\Organization;
use Modules\Gaz\Models\Staff;

/**
 * @property integer|string|null $id
 * @property integer|string $type_id
 * @property string $status_slug
 * @property integer|string $author_id
 * @property integer|string $gaz_organization_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ReqType $type
 * @property User $author
 * @property Staff $author_staff
 * @property Collection<ReqStaff> $req_staff_meta
 * @property Organization $organization
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
        'author_id',
        'gaz_organization_id',
    ];

    /**
     * Перехватываем создание модели
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        // Вызываем родительский конструктор,
        // и передаем правильные ключи полей
        parent::__construct(count($attributes) ? [
            'type_id' => $attributes['type_id'],
            'author_id' => Auth::id(),
            'gaz_organization_id' => $attributes['organization_id'],
        ] : []);
    }

    /**
     * Мутатор для даты создания заявки
     *
     * @param integer $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y H:i');
    }

    /**
     * Мутатор для даты обновления заявки
     *
     * @param integer $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y H:i');
    }

    /**
     * Получить авторизованного пользователя в заявке
     *
     * @return ReqStaff
     */
    public function getAuthUserReqStaff() {
        return $this->req_staff_meta->filter(fn($rsMeta) => $rsMeta->gaz_staff_id === Auth::user()->staff->id)->first();
    }

    /**
     * Отмечал ли пользователь уже свое участие в заявке
     *
     * @return ?boolean
     */
    public function isAuthUserAlreadyVote()
    {
        $user = $this->getAuthUserReqStaff();
        if (!$user) return null;

        return $user->accepted !== null;
    }

    public function meOrMyStaff()
    {
        return $this->req_staff_meta->some(
            fn($rsMeta) =>
                // Пользователь является руководителем кого-то из участников заявки
                $rsMeta->staff->manager_id === Auth::user()->staff->id
                // Или сам является участником
                || $rsMeta->gaz_staff_id === Auth::user()->staff->id
        );
    }

    /**
     * Может ли пользователь просматривать заявку
     *
     * @return boolean
     */
    public function canView()
    {
        return $this->isAuthUserHasFullAccess() || $this->meOrMyStaff();
    }

    /**
     * Имеет ли авторизованный пользователь полный доступ к заявке
     *
     * @return boolean
     */
    public function isAuthUserHasFullAccess()
    {
        return ($this->author_id === Auth::id()) || Auth::user()->admin;
    }

    /**
     * Получить того пользователя, который отклонил заявку
     *
     * @return ReqStaff
     */
    public function getUserWhoDenied()
    {
        return $this->req_staff_meta->filter(fn($rsMeta) => $rsMeta->accepted === false)->first();
    }

    /**
     * Получить причину, по котрой заявка была отклонена
     *
     * @return string
     */
    public function getRefusalReason()
    {
        if ($this->status->slug !== 'denied') return null;

        return $this->getUserWhoDenied()->refusal_reason;
    }

    /**
     * Связь: тип заявки
     *
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ReqType::class, 'type_id', 'id');
    }

    /**
     * Связь: статус заявки
     *
     * @return BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(ReqStatus::class, 'status_slug', 'slug');
    }

    /**
     * Связь: пользователь системы ReqSys
     *
     * @return BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    /**
     * Связь: сотрудник соответствующий автору заявки
     *
     * @return BelongsTo
     */
    public function author_staff()
    {
        return $this->author->staff();
    }

    /**
     * Связь: участники заявки
     *
     * @return HasMany
     */
    public function req_staff_meta()
    {
        return $this->hasMany(ReqStaff::class, 'req_id', 'id');
    }

    /**
     * Получить сотрудников, участвующих в заявке
     *
     * REVIEW: Пока не понимаю как лучше сделать связь
     * потому что она через другую БД
     *
     * @return Builder
     */
    public function reqStaff()
    {
        // Отключаем глобальный Scope для модели сотрудника
        // чтобы получить информацию,
        // даже если его учетная запись отключена
        return Staff::withTrashed()->whereIn(
            'id',
            $this->req_staff_meta->pluck('gaz_staff_id')
        );
    }

    /**
     * Связь: организация, в которой создана заявка
     *
     * @return BelongsTo
     */
    public function organization()
    {
        return $this->setConnection('gaz')->belongsTo(Organization::class, 'gaz_organization_id', 'id');
    }
}
