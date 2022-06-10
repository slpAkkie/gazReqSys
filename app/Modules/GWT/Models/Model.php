<?php

namespace Modules\GWT\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;



/**
 * Класс модели для модуля GWT
 */
abstract class Model extends EloquentModel
{

    /**
     * Соединение к базе данных для моделей модуля GWT
     *
     * @var string
     */
    protected $connection = 'wt';

}
