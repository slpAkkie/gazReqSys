<?php

namespace Modules\WT\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Класс модели для модуля WT
 *
 * @mixin Builder
 */
abstract class Model extends EloquentModel
{

    /**
     * Соединение к базе данных для моделей модуля WT
     *
     * @var string
     */
    protected $connection = 'wt';

}
