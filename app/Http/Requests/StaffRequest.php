<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
            'firstname' => 'required|max:100',
            'lastname' => 'required|max:100',
            'type' => 'required|max:100',
            'laboratory' => 'required_if:type,Lab Analyst,Customer Relations Officer,Lab Manager',
            'birthday' => 'required',
            'gender' => 'required|max:100',
            'email' => 'required|string|max:150|unique:users,email,'.$this->id,
            'avatar' => 'nullable|image64:jpeg,jpg',
        ];
    }
}
