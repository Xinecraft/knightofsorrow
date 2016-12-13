<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NewsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(\Auth::user()->isAdmin())
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
            'title' => 'required|min:10|max:255',
            'text' => 'required|min:25|max:5000',
            'news_type' => 'required|in:0,1',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Please provide a title for news',
            'text.required' => 'Please enter news body',
            'text.min' => 'Body must be atleast :min characters in length',
            'text.max' => 'Body must be atmost :max characters in length',
            'news_type.required' => 'Please provide a news type',
            'news_type.in' => 'News should be either Global or Tournament news',
        ];
    }
}
