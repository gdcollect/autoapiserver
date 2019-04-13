<?php

namespace AutoApiServer\Api\ApiServer\Auto;

use AutoApiServer\Api\ApiResult;
use AutoApiServer\Api\ApiServer\Auto\Requests\ApiServerRequest;
use AutoApiServer\Api\ApiServer\ConfigurationChecks;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiAutoController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $apiService;

    public function __construct(ApiServerRequest $apiServerRequest)
    {
        $this->apiService = new ApiAutoService();
        ConfigurationChecks::setTablesConfiguration();

        if(ConfigurationChecks::isTablesConfigurationSet()) {
            if (ConfigurationChecks::isMiddlewareSet($apiServerRequest->table, $apiServerRequest->type)) {
                $this->middleware(ConfigurationChecks::getMiddleware($apiServerRequest->table, $apiServerRequest->type));
            }
        }
    }

    private function validateData(string $table, string $type, array $requestBody, ApiResult &$result)
    {
        if(ConfigurationChecks::isTablesConfigurationSet()) {
            if (ConfigurationChecks::areValidationRulesSet($table, $type)) {
                $data = $requestBody["data"];
                $validator = Validator::make($data, ConfigurationChecks::getValidationRules($table, $type));
                if ($validator->fails()) {
                    $result->setError(true);
                    $result->setBody($validator->getMessageBag());
                }
            }
        }
    }

    public function router(ApiServerRequest $request)
    {
        try {
            $result = new ApiResult();

            $requestType = $request->type;
            Registry::addValue('table', $request->table);
            $requestBody = json_decode($request->get('body'), true);

            /*
             * DO VALIDATION IF RULES ARE SET
             */
            //TODO: Check if there's a better way to do this
            $this->validateData($request->table, $requestType, $requestBody, $result);

            if (!$result->isError()) {
                $result->setBody($this->apiService->queryBuilder($requestBody, $requestType));
            }

            return response()->json($result->toArray()); //Returning the result of the actions
        } catch
        (\Exception $exception) {
            // IF any exceptions thrown this will catch them up and return the cause to the Client!
            $result->setError(true);
            Log::error($exception->getMessage(), $exception->getTrace());
            $result->setBody("Bad Request Or Server-Side Error");
            return response()->json($result->toArray())
                ->setStatusCode(400);
        }
    }
}
