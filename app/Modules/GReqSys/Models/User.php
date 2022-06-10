<?php

namespace Modules\GReqSys\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Facades\Hash;

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
        'gaz_stuff_id',
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
     * Получить все заявки, созданные этим пользователем
     *
     * @return HasMany
     */
    public function reqs()
    {
        return $this->hasMany(Req::class, 'user_id', 'id');
    }

    public function stuff()
    {
        // TODO: Получение данных о сотруднике в БД Gaz
    }

}
