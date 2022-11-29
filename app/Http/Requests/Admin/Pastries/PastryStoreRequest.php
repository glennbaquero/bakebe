<?php

namespace App\Http\Requests\Admin\Pastries;

use Illuminate\Foundation\Http\FormRequest;

class PastryStoreRequest extends FormRequest
{
    protected $id;

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
             'category_id' => 'required',            
             // 'duration' => 'required|numeric',
             'difficulty' => 'required',
             'is_active' => 'required',
        ];

        if($this->id) {
            $rules['image_path'] = 'nullable|mimes:jpeg,png,jpg';
        } else {
            $rules['image_path'] = 'required|mimes:jpeg,png,jpg';
        }

        return $rules;
    }

    public function messages() {
        return [
            'category_id.required' => 'The category is required.',
        ];
    }
}
