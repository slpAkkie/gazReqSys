<?php

namespace App\Providers;

class ModulesServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot() {
        $modules = config("module.modules");
        if ($modules) {
            foreach ($modules as $module) {
                if (file_exists(__DIR__.'/../../Modules/'.$module.'/Routes/routes.php'))
                    $this->loadRoutesFrom(__DIR__.'/../../Modules/'.$module.'/Routes/routes.php');

                if (is_dir(__DIR__.'/../../Modules/'.$module.'/Views'))
                    $this->loadViewsFrom(__DIR__.'/../../Modules/'.$module.'/Views', $module);

                if(is_dir(__DIR__.'/../../Modules/'.$module.'/Migrations'))
                    $this->loadMigrationsFrom(__DIR__.'/../../Modules/'.$module.'/Migrations');

                if(is_dir(__DIR__.'/../../Modules/'.$module.'/Lang'))
                    $this->loadTranslationsFrom(__DIR__.'/../../Modules/'.$module.'/Lang', $module);
            }
        }
    }
}
