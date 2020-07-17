<?php

namespace DFM\FAQ\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFAQ extends FormRequest
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
        $locale = request()->get('locale') ?: app()->getLocale();

        return [
            'channels'           => 'required',
            "{$locale}.question" => 'required',
            "{$locale}.answer"   => 'required',
        ];
    }
}
