<?php

namespace App\Providers;

use App\Models\Company;
use Illuminate\Support\Facades\Artisan;
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

            Artisan::call('storage:link');
            Artisan::call('migrate');

            /**
             * Kijken of de URL gekoppeld zit aan een kantine
             */
            view()->share('active_company', new Company());

            Config::set('company_id', NULL);
            if ($company = Company::where('domain', $request->getHost())->first()) {
                Config::set('domain', $company->domain);
                Config::set('company_id', $company->id);
                view()->share('active_company', $company);
            }
        }
    }
}
