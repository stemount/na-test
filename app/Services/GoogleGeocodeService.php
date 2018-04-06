<?php

namespace App\Services;

use \GuzzleHttp\Client;

class GoogleGeocodeService {
  protected $apiKey;
  protected $guzzle;

  public function __construct()
  {
    $this->apiKey = config('services.google.maps_geocoder_key');
    $this->guzzle = new \GuzzleHttp\Client();
  }

  public static function make()
  {
    return new static();
  }

  public function address(String $address)
  {
    // Bail early if expected params not provided.
    if (empty($address) || empty($this->apiKey)) {
      return false;
    }

    $params['key'] = $this->apiKey;
    $params['address'] = $address;

    // Hard code the geocoder to filter by UK to prevent matches outside UK.
    $params['region'] = 'GB';

    $response = json_decode(
      $this->guzzle
        ->get('https://maps.googleapis.com/maps/api/geocode/json', [
          'query' => $params,
        ])
        ->getBody()
    );

    // @todo tidy up response handler.
    switch ($response->status) {
      case "OK":
        return $response->results[0]->geometry->location ?: [];
      break;

      /**
       * @todo This should specify the error codes instead of being a catch-all.
       */
      default:
        return FALSE;
      break;
    }

  }

}
