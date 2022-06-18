<?php

namespace Modules\ReqSys\Seeders;

use Illuminate\Database\Seeder;
use Modules\ReqSys\Models\User;
use Modules\Gaz\Models\Organization;
use Modules\Gaz\Models\Post;
use Modules\Gaz\Models\Staff;
use Modules\Gaz\Models\StaffHistory;

/**
 * Класс для заполнения всех таблиц для БД Gaz
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Заполнение таблиц
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ReqTypeSeeder::class,
            ReqStatusSeeder::class,
            ReqSeeder::class,
            ReqSeeder::class,
            ReqStaffSeeder::class,
        ]);



        for ($i = 4; $i <= 100; $i++) {
            $f = Staff::factory();
            if (!rand(0, 8)) $f = $f->trashed();

            $f->make([
                'manager_id' => ($user = Staff::inRandomOrder()->first()) ? $user->id : 1,
            ])->save();

            $notTrashed = 1;
            do {
                $notTrashed = !rand(0, 2);

                $f = StaffHistory::factory();
                if (!$notTrashed) $f = $f->trashed();

                $f->make([
                    'staff_id' => $i,
                    'post_id' => Post::inRandomOrder()->first()->id,
                    'organization_id' => Organization::inRandomOrder()->first()->id,
                ])->save();
            } while (!$notTrashed) ;

            (new User([
                'login' => 'root'.$i,
                'staff_id' => $i,
                'password' => 'root'
            ]))->save();
        }
    }
}
