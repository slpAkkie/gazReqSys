<?php

namespace Modules\Gaz\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;
use Modules\Gaz\Models\Model;

/**
 * @property integer|string|null $id
 * @property string $title
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Collection<Stuff> $stuff
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
     * @return BelongsToMany
     */
    public function stuff()
    {
        return $this->belongsToMany(
            Stuff::class,
            StuffHistory::class,
            'post_id',
            'stuff_id',
            'id',
            'id',
        )->using(StuffHistory::class)->withPivot(
            'hired_at',
            'department_id',
            'fired_at',
            'created_at',
            'updated_at',
        )->as('job_info');
    }
}
