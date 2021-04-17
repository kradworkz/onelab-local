<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name' => 'sometimes|required|max:100',
            'type' => 'sometimes|required|numeric',
            'industry' => 'sometimes|required|numeric',
            'bussiness' => 'sometimes|required|numeric',
            'classification' => 'sometimes|required|numeric',
            'region' => 'required|numeric',
            'province' => 'required|numeric',
            'municipality' => 'required|numeric',
            'address' => 'required|string|max:200',
            'mobile' => 'required|numeric|digits:11|unique:contacts,mobile_no,'.$this->id,
            'fax' => 'nullable|string',
            'tel' => 'nullable|string',
            'email' => 'sometimes|required|string|max:150|unique:users,email,'.$this->user_id,
        ];
    }
}
