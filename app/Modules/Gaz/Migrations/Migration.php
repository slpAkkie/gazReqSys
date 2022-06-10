<?php

namespace Modules\Gaz\Migrations;

use Illuminate\Database\Migrations\Migration as MigrationsMigration;

abstract class Migration extends MigrationsMigration
{

    /**
     * Соединение к базе данных для моделей модуля Gaz
     *
     * @var string
     */
    protected $connection = 'gaz';

}
