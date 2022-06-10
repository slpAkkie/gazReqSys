<?php

namespace Modules\GWT\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Facades\Hash;

class User extends AuthUser
{

    /**
     * Соединение к базе данных для моделей модуля GWT
     * Так как наследуемся не от базовой модели для этого модуля, нужно указать это явно
     *
     * @var string
     */
    protected $connection = 'wt';

    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'second_name',
        'login',
        'email',
        'insurance_number',
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
     * Получить все назначенные пользователю курсы
     *
     * @return BelongsToMany
     */
    public function courses()
    {
        return $this->belongsToMany(
            Course::class,
            UserCourse::class,
            'user_id',
            'course_id',
            'id',
            'id',
        )->using(UserCourse::class)->withPivot(
            'created_at',
            'updated_at',
        );
    }

}
