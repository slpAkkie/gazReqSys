<?php

namespace Modules\ReqSys\Migrations;

use Illuminate\Database\Migrations\Migration as MigrationsMigration;

abstract class Migration extends MigrationsMigration
{

    /**
     * Соединение к базе данных для моделей модуля ReqSys
     *
     * @var string
     */
    protected $connection = 'reqsys';

}
