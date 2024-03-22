<?php

namespace App\Http\Requests\user;

use App\Trait\ResponseJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class storeRequest extends FormRequest
{
     use ResponseJson;
     protected function failedValidation(Validator $validator)
     {
         $res = $this->sendListError($validator->errors());
         throw new HttpResponseException($res);
     }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string', 
            'last_name' => 'required|string', 
            'city' => 'required|string', 
            'address' => 'required|string', 
            'account_id' => [
            'required', 
             Rule::exists('accounts', 'id')->where(function ($query) {
                $query->where('type', 3);
             }),
            ], 
            'phoneNumber' => 'required|string|unique:users,phoneNumber', 
        ];
    }
}
