<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Exception;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function getAllCountry()
    {
        $country = Country::all();
        $response = [
            'success' => true,
            'country' => $country,
        ];
        return response($response, 201);
    }

    // used only for the insert the countries :
    public function createCountry(Request $request)
    {
        try {
            $arrayCountries = $request->all();
            if (empty($arrayCountries)) {
                $response = [
                    'error' => 'Failed to insert data',
                    'message' => 'syntax invalid or type data invalid'
                ];
            } else {
                foreach ($arrayCountries as $arr) {
                    Country::create(['name' => $arr['name'], 'callingCode' => $arr['code']]);
                }
                $response = [
                    'success' => 'Countries created successfully',
                ];
            }
            return response($response, 201);
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
