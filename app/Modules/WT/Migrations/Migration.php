<?php

namespace Modules\WT\Migrations;

use Illuminate\Database\Migrations\Migration as MigrationsMigration;

abstract class Migration extends MigrationsMigration
{

    /**
     * Соединение к базе данных для моделей модуля WT
     *
     * @var string
     */
    protected $connection = 'wt';

}
