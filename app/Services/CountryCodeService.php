<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use PragmaRX\Countries\Package\Countries;

class CountryCodeService
{
    /**
     * List countries with specific country codes.
     *
     * @param array $countryCodes Array of country codes to include in the result
     * @return array List of countries with specific country codes
     * @throws Exception
     */
    public function list(array $countryCodes)
    {
        try {
            $countryArray = [];
            $countries = Countries::all();
            
            foreach ($countries as $key => $country) {
                if (in_array($key, $countryCodes) && isset($country['calling_codes'][0]) && isset($country['flag']['emoji'])) {
                    $countryArray[] = (object)[
                        'country_code' => $key,
                        'country_name' => $country['admin'] . ' (' . $key . ')',
                        'calling_code' => $country['calling_codes'][0] == '+1201' ? '+1' : $country['calling_codes'][0],
                        'flag_emoji'   => $country['flag']['emoji'],
                    ];
                }
            }
            
            return ['data' => $countryArray];
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * Get details of a specific country.
     *
     * @param string $country Country code (e.g., 'USA')
     * @return mixed|null Details of the country
     * @throws Exception
     */
    public function show($country)
    {
        try {
            return Countries::where('cca3', $country)->first();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * Get details of a country by its calling code.
     *
     * @param string $callingCode Calling code (e.g., '+1')
     * @return array|null Details of the country
     * @throws Exception
     */
    public function callingCode($callingCode)
    {
        try {
            $countries = Countries::all();
            $callingCodeArray = Collection::make($countries)
                ->filter(function ($country, $key) use ($callingCode) {
                    return isset($country['calling_codes'][0]) && isset($country['flag']['emoji']) && $country['calling_codes'][0] == $callingCode;
                })
                ->mapWithKeys(function ($country, $key) {
                    return [
                        $country['calling_codes'][0] => (object)[
                            'country_code' => $key,
                            'calling_code' => $country['calling_codes'][0],
                            'flag_emoji'   => $country['flag']['emoji'],
                        ]
                    ];
                })
                ->toArray();
            
            if (!empty($callingCodeArray)) {
                return ['data' => reset($callingCodeArray)];
            } else {
                return null;
            }
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }
}
