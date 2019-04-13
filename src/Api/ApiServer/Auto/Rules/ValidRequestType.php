<?php

namespace AutoApiServer\Api\ApiServer\Auto\Rules;

use AutoApiServer\Api\ApiServer\ConfigurationChecks;
use Illuminate\Contracts\Validation\Rule;

class ValidRequestType implements Rule
{
    public function __construct($requestType)
    {
        $this->requestType = $requestType;
    }

    private $requestType;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (ConfigurationChecks::isTablesConfigurationSet()) {
            if (!ConfigurationChecks::areTablePropertiesSet($value) || (ConfigurationChecks::areAllowedActionsSet($value) && !ConfigurationChecks::isActionAllowed($value, $this->requestType))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Method ' . $this->requestType . ' not allowed for table :input.';
    }
}
