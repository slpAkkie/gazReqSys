<?php

namespace Modules\WT\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;
use Modules\WT\Models\Model;

/**
 * @property integer|string|null $id
 * @property string $title
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Collection<Course> $courses
 *
 * @mixin Builder
 */
class Course extends Model
{
    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * Получить всех участников этого курса
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            UserCourse::class,
            'course_id',
            'user_id',
            'id',
            'id',
        )->using(UserCourse::class)->withPivot(
            'created_at',
            'updated_at',
        )->as('metadata');
    }
}
