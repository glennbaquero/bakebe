<?php

namespace App\Http\Requests\Admin\Promos;

use Illuminate\Foundation\Http\FormRequest;

class PromoStoreRequest extends FormRequest
{
    private $id;
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
             'promo_category_id' => 'required',            
             'discount' => 'required|numeric',
             'is_percentage' => 'required|numeric',
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
            'promo_category_id.required' => 'Promo category is required.',
            'image_path.mimes' => 'Image must be JPEG, PNG or JPG file.',
            'image_path.required' => 'Image is required',
        ];
    }
}
