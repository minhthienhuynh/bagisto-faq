<?php

namespace DFM\FAQ\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFAQ extends FormRequest
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
            'channels' => 'required',
            'question' => 'required',
            'answer'   => 'required',
        ];
    }
}
