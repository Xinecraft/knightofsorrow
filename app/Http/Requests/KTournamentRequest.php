<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class KTournamentRequest extends Request
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
            'name' => 'required|min:5|max:255|unique:k_tournaments',
            'description' => 'required|min:10',
            'rules' => 'required|min:10',
            'photo' => 'required|image',
            'minimum_participants' => 'required|numeric|min:3',
            'maximum_participants' => 'required|numeric|min:3',
            'rounds_per_match' => 'required|numeric',
            'registration_starts_at' => 'required|date',
            'registration_ends_at' => 'required|date',
            'tournament_starts_at' => 'required|date',
            'bracket_type' => 'in:0,1',
            'tournament_type' => 'in:0,1,2',
        ];
    }
}
