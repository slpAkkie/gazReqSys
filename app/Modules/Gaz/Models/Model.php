<?php

namespace Modules\Gaz\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Query\Builder;

/**
 * Класс модели для модуля Gaz
 *
 * @mixin Builder
 */
abstract class Model extends EloquentModel
{

    /**
     * Соединение к базе данных для моделей модуля Gaz
     *
     * @var string
     */
    public $connection = 'gaz';

}
