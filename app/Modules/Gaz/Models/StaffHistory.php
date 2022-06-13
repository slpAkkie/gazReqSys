<?php

namespace Modules\Gaz\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Modules\Gaz\Models\Scopes\StaffHistoryScope;

/**
 * @property integer|string|null $id
 * @property integer|string|null $staff_id
 * @property integer $hired_at
 * @property integer|string|null $post_id
 * @property integer|string|null $department_id
 * @property integer $fired_at
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Staff $staff
 * @property Post $post
 * @property Department $department
 *
 * @mixin Builder
 */
class StaffHistory extends Pivot
{
    /**
     * Соединение к базе данных для моделей модуля Gaz
     * Так как наследуемся не от базовой модели для этого модуля, нужно указать это явно
     *
     * @var string
     */
    protected $connection = 'gaz';

    /**
     * Таблица, используемая моделью.
     * Необходимо указать явно, так как иначе,
     * будет преобразовано во множественное число staff_histories
     *
     * @var string
     */
    protected $table = 'staff_history';

    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'staff_id',
        'hired_at',
        'post_id',
        'department_id',
    ];

    /**
     * Хук запуска модели
     * Устанавливаем здесь глобальный Scope
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new StaffHistoryScope);
    }

    /**
     * Переопределение метода модели save
     * для проверки переданного поля hired_at.
     * В случае, если его нет, то установить
     * текущую дату
     *
     * @param array $options
     * @return StaffHistory
     */
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
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
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
