<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            try {
                $dbSettings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();

                // Merge with defaults so all keys are always available
                $defaults = [
                    'app_name' => 'Moustafa Marouf',
                    'company_name' => 'Promotion Immobilière Moustafa Marouf',
                    'company_email' => 'moustafamarouf24@gmail.com',
                    'company_phone' => '+213 770753232',
                    'company_address' => 'Cité 8 aout 1954, Ain Mkhlouf Guelma',
                    'currency' => 'DA',
                    'default_language' => 'fr',
                    'working_days_per_month' => '22',
                ];

                \Illuminate\Support\Facades\View::share('settings', array_merge($defaults, $dbSettings));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\View::share('settings', []);
            }
        }
    }
}
