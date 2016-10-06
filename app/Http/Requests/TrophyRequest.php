<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TrophyRequest extends Request
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
            'name' => 'required|min:5|max:255|unique:trophies',
            'short_name' => 'required|max:25',
            'description' => 'required|min:10',
            'max_bearer' => 'required|numeric|max:100|min:1',
            'photo' => 'required|image|max:500',
        ];
    }
}
