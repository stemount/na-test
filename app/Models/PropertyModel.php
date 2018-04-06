<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidForKey;

class PropertyModel extends Model
{
   // Override table name to pluralise db table.
    protected $table = 'properties';

    // Generate UUID.
    use UuidForKey;

    // Fields.
    protected $fillable = ['address_line1', 'address_line2', 'address_city_town', 'address_postcode', 'lat', 'lng'];
}
