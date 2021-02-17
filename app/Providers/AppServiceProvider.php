<?php

namespace App\Providers;

use App\Models\Company;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        if (app()->runningInConsole() == false) {

            /**
             * Kijken of de URL gekoppeld zit aan een kantine
             */
            if ($canteen = Company::where('domain', $request->getHost())->first()) {
                Config::set('domain', $canteen->domain);
            }
        }
    }
}
