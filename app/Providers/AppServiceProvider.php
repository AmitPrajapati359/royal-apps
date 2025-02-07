<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

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
    public function boot()
    {
        Schema::defaultStringLength(191);

        View::composer('*', function ($view) {
            $token = session('api_token');

            if ($token) {
                $authUserDetail = app('App\Services\CandidateApiService')->getLoginUser($token);
                $view->with('authUserDetail', $authUserDetail);
            }
        });
    }
}
