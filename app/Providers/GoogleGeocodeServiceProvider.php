<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GoogleGeocodeService;

class GoogleGeocodeServiceProvider extends ServiceProvider {
    /* @var bool */
    protected $defer = false;

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GoogleGeocodeService::class, function () {
          return new GoogleGeocodeService;
        });
    }
}
