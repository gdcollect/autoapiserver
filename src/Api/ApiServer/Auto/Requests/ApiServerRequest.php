<?php

namespace AutoApiServer\Api\ApiServer\Auto\Requests;

use AutoApiServer\Api\ApiResult;
use AutoApiServer\Api\ApiServer\Auto\ApiAuto;
use AutoApiServer\Api\ApiServer\Auto\Rules\ValidBody;
use AutoApiServer\Api\ApiServer\Auto\Rules\ValidRequestType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ApiServerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => [
                'bail',
                'required',
                'string',
                Rule::in(ApiAuto::getValidRequestTypes())
            ],
            'table' => [
                'bail',
                'required',
                'string',
                new ValidRequestType($this->request->get('type'))
            ],
            'body' => [
                'bail',
                'required',
                'json',
                new ValidBody($this->request->get('type')),
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $apiResult = new ApiResult();
        $apiResult->setError(true);
        $apiResult->setBody($validator->getMessageBag());
        throw new HttpResponseException(response()->json($apiResult->toArray())->setStatusCode(400));
    }
}
