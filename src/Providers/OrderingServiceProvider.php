<?php

namespace Fixme\Ordering\Providers;

use Fixme\Ordering\Ordering;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class OrderingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		$this->loadMigrationsFrom(dirname(__DIR__, 1).'/migrations');
		$this->publishes([
		    dirname(__DIR__, 2).'/config.php' => config_path('ordering.php'),
		]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		App::bind('ordering', function () {
            return new Ordering();
        });

        App::bind('Fixme\Ordering\Data\Interfaces\OrderRepository', 'Fixme\Ordering\Data\Repositories\OrderRepository');

    }
}
