<?php

namespace Modules\Gaz\Models;

use Modules\Gaz\Models\Model;

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

    public function stuff()
    {
        // TODO: Получить всех сотрудников, которые сейчас занимают эту должность
    }
}
