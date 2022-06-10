<?php

namespace Modules\GWT\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserCourse extends Pivot
{

    /**
     * Соединение к базе данных для моделей модуля GWT
     * Так как наследуемся не от базовой модели для этого модуля, нужно указать это явно
     *
     * @var string
     */
    protected $connection = 'wt';
    /**
     * Таблица, используемая моделью.
     * Необходимо указать явно, так как иначе,
     * будет использовано единственное число user_course
     *
     * @var string
     */
    protected $table = 'user_courses';

    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'course_id',
    ];

    /**
     * Получить курс назначенный пользователю
     *
     * @return void
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Получить пользователя назначенного на курс
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
