<?php

namespace App\Http\Requests\store;

use App\Trait\ResponseJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'store_name' => 'required|string|unique:stores,store_name',
            'store_detail' => 'nullable|string',
            'address' => 'nullable|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'manger_id' => 'required|exists:mangers,id',
        ];
    }
}
