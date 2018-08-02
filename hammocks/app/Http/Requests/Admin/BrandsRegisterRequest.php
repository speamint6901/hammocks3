<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class BrandsRegisterRequest extends Request
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
            "name" => 'required|alpha_half',
            "name_hiragana" => 'required|hiragana',
            "name_katakana" => 'katakana',
            "name_japan" => '',
            "name_display" => 'required',
            "brand_img_url" => 'url',
        ];
    }

    public function messages() {
        return [
            "name.required" => 'ブランド名を入力してください',
            "name.alpha_half" => 'ブランド名は半角英字のみ入力可能です',
            "name_hiragana.required" => 'ブランド名（かな）を入力してください',
            "name_hiragana.hiragana" => 'ブランド名（かな）はひらがなのみ入力可能です',
            "name_katakana.katakana" => 'ブランド名（カナ）はカタカナのみ入力可能です',
            "name_display.required" => 'ブランド名（フロント表示用）を入力してください',
            "brand_img_url.url" => 'ブランド画像ＵＲＬは無効な形式です',
        ];
    }
}
