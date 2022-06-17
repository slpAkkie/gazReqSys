<?php

namespace Modules\WT\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Gaz\Models\Staff;
use Modules\WT\Jobs\SendEmail;
use Modules\WT\Mail\ReactivateMail;
use Modules\WT\Mail\RegistrationMail;

/**
 * @property integer|string|null $id
 * @property string $first_name
 * @property string $last_name
 * @property string $second_name
 * @property string $login
 * @property string $password_hash
 * @property string $password_salt
 * @property string $email
 * @property string $insurance_number
 * @property integer $deleted_at
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Collection<Course> $courses
 *
 *
 * @mixin Builder
 */
class User extends AuthUser
{
    /**
     * Соединение к базе данных для моделей модуля WT
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
     * Не хэшированный пароль
     * Сохраняется при создании пользователя
     * Чтобы отправить письмо с ним
     *
     * @var string
     */
    private string $unhashed_password;

    /**
     * Создание новой записи
     *
     * @param Staff $attributes
     *
     * @return User
     */
    static public function new(Staff $attributes)
    {
        $model = new self($attributes->toArray());

        $model->generatePassword();
        $model->generateLogin();

        $model->sendRegistrationEmail();

        return $model;
    }

    /**
     * Отправить пользователю письмо с данными для входа
     *
     * @return void
     */
    private function sendRegistrationEmail()
    {
        dispatch(new SendEmail($this->email, RegistrationMail::class, [
            'login' => $this->login,
            'password' => $this->unhashed_password,
        ]));
    }

    /**
     * Отправить письмо пользователю о том, что его аккаунт восстановлен
     * с новыми данными для входа
     *
     * @return void
     */
    private function sendReactivateEmail()
    {
        dispatch(new SendEmail($this->email, ReactivateMail::class, [
            'login' => $this->login,
            'password' => $this->unhashed_password,
        ]));
    }

    /**
     * Сгенерировать пароль для пользователя
     *
     * @return void
     */
    private function generatePassword()
    {
        $this->password_hash = $this->hashPassword($this->unhashed_password = Str::random(8));
    }

    /**
     * Поулчить массив транслитерованных частей ФИО
     *
     * @return array
     */
    private function getTranslitedFullNameArr()
    {
        return array_map(
            // Преобразуем ФИО так, что бы части были с большой буквы
            function ($v) { return Str::ucfirst($v); },
            // Преобразовать ФИО в транслит, и разбить по разделителю
            // Получим массив ФИО в транслитерации
            explode('-', Str::slug($this->getFullName()))
        );
    }

    /**
     * Сгенерировать логин для пользователя
     *
     * @return void
     */
    private function generateLogin()
    {
        /**
         * Части имени в транслитерации
         *
         * @var array
         */
        $full_name_arr = $this->getTranslitedFullNameArr();

        /**
         * @var string Возможный Логин
         */
        $possibleLogin = null;

        // Данные для генерации логина

        /**
         * @var int Сколько букв брать из имени
         */
        $loginSecondPartLength = 1;
        /**
         * @var int Сколько букв брать из отчества
         */
        $loginThirdPartLength = 1;
        /**
         * True в случае, когда все символы ФИО уже использованы,
         * но логин все еще занят
         *
         * @var bool Индикатор, что в конце логина нужно дописать рандомные символы
         */
        $appendSlug = false;

        // Генерируем логин до тех пор, пока не найдем свободный
        do {
            // Склеиваем логин из ФИО, используя данные для генерации
            $possibleLogin = $full_name_arr[0]
                .Str::substr($full_name_arr[1], 0, $loginSecondPartLength)
                .Str::substr($full_name_arr[2], 0, $loginThirdPartLength)
                // Если индикатор $appendSlug установлен в true, добавляем к логину 3 случайных символа
                .($appendSlug ? Str::random(3) : '');

            // Проверяем данные для генерации
            // Увечиваем количество симолов, вытаскиваемых из имени и отчества
            // Если все символы использованы устанавливаем индиктор $appendSlug
            if ($loginSecondPartLength === strlen($full_name_arr[1]))
                if ($loginThirdPartLength === strlen($full_name_arr[2])) $appendSlug = true;
                else $loginThirdPartLength++;
            else $loginSecondPartLength++;
        } while (User::where('login', $possibleLogin)->count());

        $this->login = $possibleLogin;
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
     * Отключить учетную запись пользователя
     *
     * @return $this
     */
    public function disable()
    {
        $this->disabled = true;
        $this->save();

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function enable()
    {
        $this->disabled = false;
        $this->generatePassword();
        $this->save();

        $this->sendReactivateEmail();

        return $this;
    }

    /**
     * Поулчить ФИО пользователя
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->last_name.' '.$this->first_name.' '.$this->second_name;
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
        )->as('metadata');
    }
}
