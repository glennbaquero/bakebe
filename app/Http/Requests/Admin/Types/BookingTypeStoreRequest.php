<?php

namespace App\Http\Requests\Admin\Types;

use Illuminate\Foundation\Http\FormRequest;

class BookingTypeStoreRequest extends FormRequest
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
        $this->id = $this->route('id');
        

        $rules = [
             'name' => 'required',
             'rate' => 'required|numeric',
             'additional_fee' => 'required|numeric',
             'expected_duration' => 'required',
        ];
        if($this->id) {
            $rules['image_path'] = 'nullable|mimes:jpeg,png,jpg';
        } else {
            $rules['image_path'] = 'required|mimes:jpeg,png,jpg';
        }
        return $rules;
    }
}
