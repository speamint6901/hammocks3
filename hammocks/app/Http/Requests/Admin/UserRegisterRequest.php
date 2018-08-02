<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UserRegisterRequest extends Request
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
            "name" => 'required|min:6|alpha_num_half|unique:admin_user_account,name',
            "email"  => 'required|email|is_domain|unique:admin_user_account,email',
            "password" => 'required|min:6|alpha_num_hyphen_half',
        ];
    }
}
