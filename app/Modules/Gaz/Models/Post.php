<?php

namespace Modules\Gaz\Models;

use Illuminate\Database\Query\Builder;
use Modules\Gaz\Models\Model;

/**
 * @property integer|string|null $id
 * @property string $title
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @mixin Builder
 */
class Post extends Model
{
    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * Получить всех сотрудников, которые сейчас занимают эту должность
     *
     * @return Builder
     */
    public function staff()
    {
        return Staff::leftJoin(
            'staff_history',
            'staff_history.staff_id', 'staff.id'
        )->whereNull('staff_history.fired_at')
        ->where('staff_history.post_id', $this->id)->with('job_meta');
    }
}
