<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessBooking extends FormRequest
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
            'daily_expenses_allowed'        => 'max:16',
            'assistant_laborers_allowed'    => 'max:16',
            'appropriation_travel_charged'  => 'max:16',
            'objectives'                    => 'string|max:300',
            'driver'                        => 'required',
            'vehicle'                       => 'required',
            'remarks'                       => 'string|max:300',
        ];
    }
}
