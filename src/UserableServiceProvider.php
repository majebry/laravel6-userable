<?php

namespace Majebry\LaravelUserable;

use Illuminate\Support\ServiceProvider;
use Majebry\LaravelUserable\Console\MakeUserable;

class UserableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeUserable::class
            ]);
        }

        if (! class_exists('AddUserableMorphsToUsersTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/add_userable_morphs_to_users_table.php.stub' => database_path('migrations/' . date('Y_m_d_his', time()) . '_add_userable_morphs_to_users_table.php')
            ], 'migrations');
        }
    }
}
