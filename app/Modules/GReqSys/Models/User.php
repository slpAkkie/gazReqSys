<?php

namespace Modules\GReqSys\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Facades\Hash;
use Modules\Gaz\Models\Staff;

/**
 * @property integer|string|null $id
 * @property string $login
 * @property string $password_hash
 * @property integer|string|null $gaz_staff_id
 * @property string $remember_token
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Collection<Req> $reqs
 * @property Staff $staff
 *
 * @method string hashPassword()
 * @method bool checkPassword()
 *
 * @mixin Builder
 */
class User extends AuthUser
{
    /**
     * Соединение к базе данных для моделей модуля GReqSys
     * Так как наследуемся не от базовой модели для этого модуля, нужно указать это явно
     *
     * @var string
     */
    protected $connection = 'reqsys';

    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'login',
        'gaz_staff_id',
    ];

    /**
     * Создать нового пользователя
     *
     * @param array $attributes
     */
    static public function new(array $attributes)
    {
        $password = $attributes['password'];
        unset($attributes['password']);

        $model = new self($attributes);
        $model->password_hash = $model->hashPassword($password);

        return $model;
    }

    /**
     * Функция хэширования пароля
     *
     * @param string $passwd
     * @return string
     */
    public function hashPassword(string $passwd)
    {
        return Hash::make($passwd);
    }

    /**
     * Проверить строку на совпадение с паролем
     *
     * @param string $passwd
     * @return bool
     */
    public function checkPassword(string $passwd)
    {
        return Hash::check($passwd, $this->password_hash);
    }

    /**
     * Получить все заявки, созданные этим пользователем
     *
     * @return HasMany
     */
    public function reqs()
    {
        return $this->hasMany(Req::class, 'user_id', 'id');
    }

    /**
     * Получить сотрудника по пользователю
     *
     * @return BelongsTo
     */
    public function staff()
    {
        return $this->setConnection('gaz')->belongsTo(Staff::class, 'gaz_staff_id', 'id')->withoutGlobalScopes();
    }
}
