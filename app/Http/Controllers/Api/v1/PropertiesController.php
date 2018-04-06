<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\PropertyModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

use App\Facades\GoogleGeocode;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the all properties.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = PropertyModel::all();

        return response()->json($properties);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate fields.
        $validator = Validator::make($request->all(), [
          'address_line1' => 'required|max:255',
          'address_city_town' => 'required|max:255',
          'address_postcode' => 'required|max:255'
        ]);

        if ($validator->fails()) {
          return response()->json(
            $validator->errors(),
            406
          );
        }

        // Concatenate address to send to Google Geocoding API as a string.
        $address = join(', ', [
          $request->get('address_line1'),
          $request->get('address_line2') || NULL,
          $request->get('address_city_town'),
          $request->get('address_postcode'),
        ]);

        // Create new property object.
        $property = new PropertyModel($request->all());

        // Save record.
        try {
          $latlng = GoogleGeocode::address($address);

          $property->lat = $latlng->lat;
          $property->lng = $latlng->lng;

          $property->save();
          return response()->json($property->getAttributes());
        }
        catch (QueryException $e) {
          return response()->json(
            $e->getMessage(),
            406
          );
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $property = PropertyModel::query()
          ->where('id', $request->property)
          ->first();

        if (!$property) {
          return response()->json(
            ['property' => ['Cannot find property.']],
            404
          );
        }

        return response()->json($property);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PropertyModel $properties
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PropertyModel $properties)
    {
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PropertyModel  $properties
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PropertyModel $properties)
    {
        return abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PropertyModel  $properties
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyModel $properties)
    {
        return abort(403);
    }
}
