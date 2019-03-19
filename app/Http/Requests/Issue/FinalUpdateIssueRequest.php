<?php

namespace App\Http\Requests\Issue;

use Illuminate\Foundation\Http\FormRequest;

class FinalUpdateIssueRequest extends FormRequest
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
        if($this->diagnostic == 'software'){
            return [
                'imei_stage_3' => 'required|digits:15',
                'solution' => 'required',
                'images.*' => 'image|mimes:jpg,jpeg,png|max:6144'
            ];
        }
        return [
                'imei_stage_3' => 'required|digits:15',
                'problems' => 'required',
                'solution' => 'required',
                'images.*' => 'required|image|mimes:jpg,jpeg,png|max:6144',
                'charges' => 'numeric'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'imei_stage_3.required' => 'You must Fill the IMEI field with the real one',
            'imei_stage_3.digits'  => 'IMEI must be 15 digits',
        ];
    }
}
