<?php

namespace App\Http\Requests\Admin\Branches;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\Varchar;
use App\Rules\HTMLText;
use App\Rules\Image;

class BranchStoreRequest extends FormRequest
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
        $id = $this->route('id');

        $rules = [
             'name' => 'required',
             'available_oven' => 'required',            
             'location' => 'required',
             'longitude' => 'required',
             'latitude' => 'required',
        ];
    
        return $rules;
    }
}
