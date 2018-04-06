<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class GoogleGeocode extends Facade
{
  /**
   * Initialise facade.
   *
   * @return string
   */
  protected static function getFacadeAccessor() { return 'App\Services\GoogleGeocodeService'; }
}
