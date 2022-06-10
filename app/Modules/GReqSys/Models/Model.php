<?php

namespace Modules\GReqSys\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Query\Builder;

/**
 * Класс модели для модуля GReqSys
 *
 * @mixin Builder
 */
abstract class Model extends EloquentModel
{

    /**
     * Соединение к базе данных для моделей модуля GReqSys
     *
     * @var string
     */
    protected $connection = 'reqsys';

}
