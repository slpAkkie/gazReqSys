<?php

namespace Modules\Gaz\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Gaz\Models\Model;

class StuffHistory extends Model
{
    /**
     * Таблица, используемая моделью.
     * Необходимо указать явно, так как иначе,
     * будет преобразовано во множественное число stuff_histories
     *
     * @var string
     */
    protected $table = 'stuff_history';

    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'stuff_id',
        'hired_at',
        'post_id',
        'department_id',
    ];

    public function save(array $options = [])
    {
        if (!in_array('hired_at', $options)) $options['hired_at'] = Carbon::now();

        parent::save($options);
    }

    /**
     * Получить сотрудника
     *
     * @return BelongsTo
     */
    public function stuff()
    {
        return $this->belongsTo(Stuff::class, 'stuff_id', 'id');
    }

    /**
     * Поулчить должность
     *
     * @return BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    /**
     * Получить организацию
     *
     * @return BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
