<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LabReportResultRequest extends FormRequest
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
        $rules['is_complete'] = 'required';
        foreach ($this->request->get('test_datas') as $key => $val) {
            $rules['test_datas.' . $key] = 'required';
        }

        return $rules;
    }
}
