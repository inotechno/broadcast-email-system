<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('max_attachments_size', function ($attribute, $value, $parameters, $validator) {
            $totalSize = array_sum(array_map(function ($file) {
                return $file->getSize();
            }, $value));

            return $totalSize <= $parameters[0] * 1024; // Convert to KB
        });
        //
    }
}
