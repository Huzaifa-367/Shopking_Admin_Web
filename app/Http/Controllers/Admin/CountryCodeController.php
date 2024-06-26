<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Services\CountryCodeService;
use App\Http\Resources\CountryCodeResource;

class CountryCodeController extends AdminController
{
    public CountryCodeService $countryCodeService;

    public function __construct(CountryCodeService $countryCodeService)
    {
        parent::__construct();
        $this->countryCodeService = $countryCodeService;
    }

    public function index(): \Illuminate\Http\Response | array | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $countryCodes = ['PAK'];
            return $this->countryCodeService->list($countryCodes);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show($country): \Illuminate\Http\Response | CountryCodeResource | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new CountryCodeResource($this->countryCodeService->show($country));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
    public function callingCode($callingCode)
    {
        try {
            return $this->countryCodeService->callingCode($callingCode);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
