<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Collection;

class ModelNotFound extends Exception
{
    /**
     * Сообщение об ошибка
     *
     * @var string
     */
    public $message;

    /**
     * Конструктор исключения
     *
     * @param array $ids
     */
    public function __construct($ids)
    {
        $this->message = 'Записи с идентификатором ' . Collection::make($ids)->join(', ') . ' не найдены';
    }
}
