<?php

namespace Modules\ReqSys\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Query\Builder;

/**
 * Класс модели для модуля ReqSys
 *
 * @mixin Builder
 */
abstract class Model extends EloquentModel
{

    /**
     * Соединение к базе данных для моделей модуля ReqSys
     *
     * @var string
     */
    public $connection = 'reqsys';

}
