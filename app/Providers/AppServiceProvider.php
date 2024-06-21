<?php

namespace App\Providers;

use App\Traits\MenuTrait;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    use MenuTrait;

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! app()->runningInConsole() || app()->runningUnitTests()) {
            View::share('menus', $this->get_menu());
        }
    }
}
