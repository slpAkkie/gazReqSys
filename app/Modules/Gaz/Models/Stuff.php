<?php

namespace Modules\Gaz\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Gaz\Models\Model;

/**
 * TODO: Валидировать ввденный снилс регулярным выражением (Формат снилса: 000-000-000 00)
 */
class Stuff extends Model
{
    /**
     * Таблица, используемая моделью.
     * Необходимо указать явно, так как иначе,
     * будет преобразовано во множественное число stuffs
     *
     * @var string
     */
    protected $table = 'stuff';

    /**
     * Поля, разрешенные для массовго заполнения
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'second_name',
        'emp_number',
        'email',
        'insurance_number',
    ];


    public function is_fired()
    {
        // TODO: Проверить уволен ли сотрудник (Все записи в таблицe stuff_history имеют заполненный столбец fired_at)

        return false;
    }

    public function last_hired()
    {
        // TODO: Получить последнюю запись о найме из таблицы stuff_history
    }

    public function department()
    {
        // TODO: Получить текущую организацию из таблицы stuff_history
    }

    public function post()
    {
        // TODO: Получить текущую должность из таблица stuff_history
    }

    public function wt_user()
    {
        // TODO: Получить записи из БД WT об аккаунте сотрудника
    }

    public function involved_in_reqs()
    {
        // TODO: Получить записи из БД GReqSys о заявках, в которые сотрудник был вовлечен
    }

    /**
     * Получить историю приема и увольнения с работы сотрудника
     *
     * @return HasMany
     */
    public function history()
    {
        return $this->hasMany(StuffHistory::class, 'stuff_id', 'id');
    }
}
