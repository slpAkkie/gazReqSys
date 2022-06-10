<?php

namespace Modules\GReqSys\Migrations;

use Illuminate\Database\Migrations\Migration as MigrationsMigration;

abstract class Migration extends MigrationsMigration
{

    /**
     * Соединение к базе данных для моделей модуля GReqSys
     *
     * @var string
     */
    protected $connection = 'reqsys';

}
