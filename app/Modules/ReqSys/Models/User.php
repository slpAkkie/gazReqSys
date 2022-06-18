<?php

namespace Modules\ReqSys\Models;

use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Gaz\Models\Staff;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @property integer|string|null $id
 * @property string $login
 * @property string $password_hash
 * @property string $password_salt
 * @property integer|string|null $gaz_staff_id
 * @property string $remember_token
 * @property bool $admin
 * @property integer $deleted_at
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Collection<Req> $reqs
 * @property Staff $staff
 *
 * @mixin Builder
 */
class User extends AuthUser
{
    /**
     * Используем трейт SoftDeltes
     */
    use SoftDeletes;

    /**
     * Соединение к базе данных для моделей модуля ReqSys
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
     * Перехватываем создание модели
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct(count($attributes) ? [
            'login' => $attributes['login'],
            'gaz_staff_id' => $attributes['staff_id'],
        ] : []);

        if (key_exists('password', $attributes)) $this->setPassword($attributes['password']);
    }

    /**
     * Сгенерировать соль для пароля
     *
     * @return void
     */
    private function generatePasswordSalt()
    {
        $this->password_salt = Str::random(64);
    }

    /**
     * Посолить пароль
     *
     * @param string $passwd
     * @return string
     */
    private function saltPassword(string $passwd)
    {
        return $this->password_salt . $passwd;
    }

    /**
     * Установить пароль для пользователя
     *
     * @param string $passwd
     * @return void
     */
    private function setPassword(string $passwd)
    {
        $this->generatePasswordSalt();
        $this->password_hash = $this->hashPassword(
            $this->saltPassword($passwd)
        );
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
        return Hash::check($this->saltPassword($passwd), $this->password_hash);
    }

    /**
     * Связь: заявки созданные пользователем
     *
     * @return HasMany
     */
    public function reqs()
    {
        return $this->hasMany(Req::class, 'user_id', 'id');
    }

    /**
     * Связь: сотрудник
     *
     * @return BelongsTo
     */
    public function staff()
    {
        return $this->setConnection('gaz')->belongsTo(Staff::class, 'gaz_staff_id', 'id')->withTrashed();
    }
}
