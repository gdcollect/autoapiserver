<?php

namespace AutoApiServer\Api\ApiServer\Auto;

use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;

class ApiAuto
{


    public static function setRoutes()
    {
        Route::post('/auto', "\\" . ApiAutoController::class . '@router')->middleware(CheckClientCredentials::class);
    }

    public static function getValidRequestTypes()
    {
        return [
            'GET',
            'POST',
            'UPDATE',
            'DELETE'
        ];
    }
}
