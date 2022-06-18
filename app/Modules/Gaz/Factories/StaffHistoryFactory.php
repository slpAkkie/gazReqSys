<?php

namespace Modules\Gaz\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Gaz\Models\StaffHistory;

class StaffHistoryFactory extends Factory
{
    /**
     * Модель для генерации
     *
     * @var [type]
     */
   protected $model = StaffHistory::class;

   /**
    * Определение для генерации
    *
    * @return array
    */
   public function definition(): array
   {
        return [
            //
        ];
   }
}
