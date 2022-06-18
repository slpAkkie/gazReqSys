<?php

namespace Modules\WT\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Modules\WT\Models\Model;

/**
 * @property integer|string|null $id
 * @property string $title
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Collection<User> $users
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
        return User::leftJoin(
            'user_courses',
            'user_courses.user_id', 'users.id'
        )->whereNull('users.deleted_at')
        ->where('user_courses.course_id', $this->id);
    }
}
