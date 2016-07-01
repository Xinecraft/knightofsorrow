<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PollRequest extends Request
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
            'question' => 'required',
            'options' => 'required',
            'closed_at' => 'required|date'
        ];
    }

    public function messages()
    {
        return [
            'question.required' => 'Please enter Poll Question',
            'options.required' => 'Please enter atleast one option',
            'closed_at.required' => 'Please specify poll end date',
            'closed_at.date' => 'Please enter a valid date',
        ];
    }
}
