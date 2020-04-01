<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBooking extends FormRequest
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
            'requestor_name'                => 'required|string|max:100',
            'requestor_position'            => 'required|string|max:100',
            'requestor_monthly_salary'      => 'required|string|max:12',
            'requestor_official_station'    => 'required|string|max:100',
            'departure_date'                => 'required',
            'return_date'                   => 'required',
            'destination'                   => 'required|string|max:300',
            'purpose'                       => 'required|string|max:300',
            // 'objectives'                    => 'required|string|max:300',
            // 'remarks'                       => 'required|string|max:300',
        ];
    }
}
