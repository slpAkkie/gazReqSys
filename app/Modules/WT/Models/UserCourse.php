<?php

namespace Modules\WT\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Query\Builder;

/**
 * @property integer|string|null $id
 * @property integer|string|null $user_id
 * @property integer|string|null $course_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Course $course
 * @property User $user
 *
 * @method string hashPassword()
 * @method bool checkPassword()
 *
 * @mixin Builder
 */
class UserCourse extends Pivot
{
    /**
     * Соединение к базе данных для моделей модуля WT
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
     * @return BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Получить пользователя назначенного на курс
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
