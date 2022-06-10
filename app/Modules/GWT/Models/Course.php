<?php

namespace Modules\GWT\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\GWT\Models\Model;

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
    public function courses()
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
        );
    }
}
