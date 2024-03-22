<?php

namespace App\Http\Requests\product;

use App\Trait\ResponseJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class store extends FormRequest
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
             'name' => 'required|string' ,
             'size' => 'required|in:0,1,2,3,4,5',
             'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
             'total_amount' => 'required|integer' ,
             'price' => 'required|numeric' ,
             'prod_detail' => 'nullable|string' ,
             'type_id' => 'required|exists:types,id' ,
             'store_id' => 'required|exists:stores,id' ,
             'color_id' => 'required|exists:colors,id' ,

        ];
    }
}
