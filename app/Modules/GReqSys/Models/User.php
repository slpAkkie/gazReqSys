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
     * Перехватываем создание модели,
     * чтобы при наличии поля password (пароль)
     * хэшировать его и записать в модель
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        if (key_exists('password', $attributes)) {
            $this->password_hash = $attributes['password_hash'] = $this->hashPassword($attributes['password']);

            // Если не удалить поле password будет ошибка,
            // что нет такого столбца в таблице
            unset($attributes['password']);
        }

        parent::__construct($attributes);
    }

    /**
     * Функция хэширования пароля
     * TODO: Для большей безопасности можно добавить соль в пароль
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
        return $this->setConnection('gaz')->belongsTo(Staff::class, 'gaz_staff_id', 'id');
    }
}
