<?php

namespace Modules\Gaz\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;



/**
 * Класс модели для модуля Gaz
 */
abstract class Model extends EloquentModel {

    /**
     * Соединение к базе данных для моделей модуля Gaz
     *
     * @var string
     */
    protected $connection = 'gaz';

}
