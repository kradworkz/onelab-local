<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrseriesRequest extends FormRequest
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
            'name' => 'required|max:100|unique:finance_orseries,name,'.$this->id,
            'start' => 'required|numeric|gt:0',
            'end' => 'required|numeric|gt:start',
            'type' => 'required|numeric',
        ];
    }
}
