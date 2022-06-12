<?php

namespace Modules\GWT\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Modules\GWT\Models\User;

class BackController extends \App\Http\Controllers\Controller
{
    /**
     * Создает аккаунт по данным о сотруднике
     *
     * @param array $staffData
     * @return void
     */
    private function createAccount(array $staffData)
    {
        $user = User::new($staffData);

        $user->save();
    }

    /**
     * Обрабатвыает создание аккаунтов для сотрудников
     *
     * @param Collection<array> $staffCollection
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
        $users = User::whereIn('insurance_number', $staffCollection->reduce(function ($r, $v) {
            $r[] = $v['insurance_number'];

            return $r;
        }, []))->get(); // TODO: REVIEW

        foreach ($staffCollection as $staff) {
            // Проверяем есть ли у этого сотрудника аккаунт
            $user = $users->first(function ($u) use ($staff) {
                return $u->insurance_number === $staff['insurance_number'];
            });

            // У тех, кто уже имеет аккаунт, если он отключен - активируем
            if ($user && $user->disabled) {
                $user->disabled = false;
                $user->save();
            }
            // Для остальных создаем аккаунт
            else if(!$user) {
                $this->createAccount($staff);
            }
        }

        return response()->json();
    }
}
