<?php

namespace Alireza\LaravelFileExplorer\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoadDirItemsRequest extends BaseRequest
{
    /**
     * Set validation rule
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "path" => ["required", "string"]
        ];
    }

    /**
     * Set validation error message
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            "path.required" => "Directory path is required",
            "path.string" => "Directory path must be string"
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = $this->getFailureResponse();
        throw new HttpResponseException($response);
    }
}