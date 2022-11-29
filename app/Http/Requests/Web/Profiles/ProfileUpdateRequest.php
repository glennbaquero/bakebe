<?php

namespace App\Http\Requests\Web\Profiles;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Admin\Users\UserStoreRequest;

class ProfileUpdateRequest extends UserStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->id = $this->user()->id;

            $rules = [
                 'first_name' => 'required',
                 'last_name' => 'required',
                 'mobile_number' => 'required',
            ];

            return $rules;
        }
    }
}
