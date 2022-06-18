<?php

namespace Modules\WT\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Modules\Gaz\Models\Staff;
use Modules\WT\Models\User;

class BackController extends \App\Http\Controllers\Controller
{
    /**
     * Создает аккаунт по данным о сотруднике
     *
     * @param Staff $staffData
     * @return void
     */
    private function createAccount(Staff $staff)
    {
        (new User($staff->toArray()))->save();
    }

    /**
     * Обрабатвыает создание аккаунтов для сотрудников
     *
     * @param Collection<Staff> $staffCollection
     * @return JsonResponse
     */
    public function createAccounts(Collection $staffCollection)
    {
        /**
         * Ищем возможно зарегистрированных пользователей
         * с такими данными сотрудников
         *
         * @var Collection<User>
         */
        $alreadyRegistered = User::whereIn('insurance_number', $staffCollection->pluck('insurance_number'))->get();

        foreach ($staffCollection as $staff) {
            // Проверяем есть ли у этого сотрудника аккаунт
            $user = $alreadyRegistered->first(function ($r) use ($staff) {
                return $r->insurance_number === $staff->insurance_number;
            });

            // У тех, кто уже имеет аккаунт, если он отключен - активируем
            if ($user && $user->disabled) $user->enable();
            // Для остальных создаем аккаунт
            else if(!$user) $this->createAccount($staff);
        }

        return response()->json();
    }
}
