<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gaz\Seeders\DatabaseSeeder as GazSeedersDatabaseSeeder;
use Modules\GReqSys\Seeders\DatabaseSeeder as GReqSysDatabaseSeeder;
use Modules\GWT\Seeders\DatabaseSeeder as GWTSeedersDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            GazSeedersDatabaseSeeder::class,
            GReqSysDatabaseSeeder::class,
            GWTSeedersDatabaseSeeder::class,
        ]);
    }
}
