<?php

namespace Modules\Gaz\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Gaz\Models\Staff;

class StaffFactory extends Factory
{
    /**
     * Модель для генерации
     *
     * @var [type]
     */
   protected $model = Staff::class;

   /**
    * Определение для генерации
    *
    * @return array
    */
   public function definition(): array
   {
       return [
           'last_name'         => $this->faker->lastName(),
           'first_name'        => $this->faker->firstName(),
           'second_name'       => $this->faker->lastName(),
           'emp_number'        => $this->faker->unique()->numerify('######'),
           'email'             => $this->faker->unique()->email(),
           'insurance_number'  => $this->faker->unique()->numerify('###-###-### ##'),
       ];
   }
}
