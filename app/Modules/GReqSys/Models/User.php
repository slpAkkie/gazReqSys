<?php

namespace Modules\GReqSys\Models;

use Illuminate\Foundation\Auth\User as AuthUser;

class User extends AuthUser
{

    /**
     * Соединение к базе данных для моделей модуля GReqSys
     * Так как наследуемся не от базовой модели для этого модуля, нужно указать это явно
     *
     * @var string
     */
    protected $connection = 'reqsys';

}
