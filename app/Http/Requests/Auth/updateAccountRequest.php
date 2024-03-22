<?php

namespace App\Http\Requests\Auth;

use App\Trait\ResponseJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class updateAccountRequest extends FormRequest
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
            'email' => "required|email|max:191|unique:accounts,email,".$this->id,
            'userName' => "required|string|max:191|unique:accounts,userName,".$this->id,
            'password' => "required|string|min:6",
            'type' => 'required|integer',
        ];
    }

}
