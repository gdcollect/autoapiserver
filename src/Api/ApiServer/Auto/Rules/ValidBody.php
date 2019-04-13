<?php

namespace AutoApiServer\Api\ApiServer\Auto\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ValidBody implements Rule
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
        $data = json_decode($value, true);
        $rules = [];
        switch ($this->requestType) {
            case "GET":
                $rules['select'] = ['array', 'min:1'];
                $rules['where'] = ['array', 'min:1'];
                $rules['whereIn'] = ['array', 'min:1'];
                break;
            case "POST":
                $rules['data'] = ['required', 'array', 'min:1'];
                break;
            case "UPDATE":
                $rules['data'] = ['required', 'array', 'min:1'];
                $rules['where'] = ['required_without:whereIn', 'array', 'min:1'];
                $rules['whereIn'] = ['required_without:where', 'array', 'min:1'];
                break;
            case "DELETE":
                $rules['where'] = ['required_without:whereIn', 'array', 'min:1'];
                $rules['whereIn'] = ['required_without:where', 'array', 'min:1'];
                break;
            default:
                return false;
        }


        $validator = Validator::make($data, $rules);

        return !$validator->fails();

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute has no valid structure.';
    }
}
