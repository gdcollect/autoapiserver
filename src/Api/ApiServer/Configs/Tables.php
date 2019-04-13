<?php

namespace AutoApiServer\Api\ApiServer\Configs;


use AutoApiServer\Api\ApiServer\Auto\Middleware\TestMiddleware;

class Tables
{
    protected static function getTablesConfiguration()
    {
        $configuration = [];
        $configuration['demo'] = [
            'allowedActions' => ['POST', 'GET', 'UPDATE', 'DELETE'],
            'validation' => [
                'POST' => [
                    'name' => 'required|min:8|max:100',
                    'description' => 'required|min:10|max:100'
                ]
            ],
//            'middleware' => [
//                'GET' => [
//                    TestMiddleware::class
//                ]
//            ]
        ];
        $configuration['migrations'] = [
            'allowedActions' => ['POST'],
        ];
        return $configuration;
    }
}
