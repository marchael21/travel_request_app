<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicle extends FormRequest
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
            'brand'             => 'required|string|max:50',
            'model'             => 'required|string|max:50',
            'year'              => 'required',
            'plate_number'      => 'required|string|max:50|unique:vehicles',
            'cor_number'        => 'required|string|max:50|unique:vehicles',
            'status'            => 'required',
        ];
    }
}
