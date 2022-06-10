<?php

namespace Modules\GWT\Migrations;

use Illuminate\Database\Migrations\Migration as MigrationsMigration;

abstract class Migration extends MigrationsMigration
{

    /**
     * Соединение к базе данных для моделей модуля GWT
     *
     * @var string
     */
    protected $connection = 'wt';

}
