<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class AuthControllerRequest extends Request
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
        $error = [
            "email"  => 'required|email|is_domain|exists:admin_user_account,email',
            "password" => 'required|min:6|alpha_num_hyphen_half|exists:admin_user_account,password',
        ];

        return $error;
    }
}
