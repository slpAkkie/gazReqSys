<?php

namespace Modules\GReqSys\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;



/**
 * Класс модели для модуля GReqSys
 */
abstract class Model extends EloquentModel {

    /**
     * Соединение к базе данных для моделей модуля GReqSys
     *
     * @var string
     */
    protected $connection = 'greqsys';

}
