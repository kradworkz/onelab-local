<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRequest extends FormRequest
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
            'reference' => 'sometimes|required|max:100',
            'duedate' => 'required|max:100',
            'type' => 'required|numeric',
            'laboratory' => 'required|numeric',
            'purpose' => 'required|numeric',
            'from' => 'required|numeric',
            'customer' => 'required|numeric',
            'conforme' => 'required|numeric',
            'mode' => 'required|numeric',
            'discount' => 'required|numeric',
            'agency' => 'required'
        ];
    }
}
