<?php

namespace App\Http\Requests\Admin\Coupons;

use Illuminate\Foundation\Http\FormRequest;

class CouponStoreRequest extends FormRequest
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
             'code' => 'required|unique:coupons,code' . ($this->id ? ',' . $this->id : ''),
             'name' => 'required',
             'discount' => 'required|numeric',            
             'discount_type' => 'required',
             'usage_start_date_time' => 'required',
             'usage_end_date_time' => 'required',
             'is_percentage' => 'required',
             'valid_start_at' => 'required',
             'valid_end_at' => 'required',
             'max_usage' => 'required',
             'max_user' => 'required',
        ];

        return $rules;
    }

    public function messages() {
        return [
            'valid_start_at.required' => 'Validity of Coupon is required, please add validity start.',
            'valid_end_at.required' => 'Validity of Coupon is required, please add validity end.',
            'is_percentage.required' => 'Discount Type is required.',
            'usage_start_date_time.required' => 'Usage Start Date and Time is required.',
            'usage_end_date_time.required' => 'Usage End Date and Time is required.'
        ];
    }
}
