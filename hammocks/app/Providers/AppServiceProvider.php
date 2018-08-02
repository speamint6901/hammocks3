<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //半角英字チェック
        Validator::extend('alpha_half', function($attribute, $value, $parameters, $validator) {

            return preg_match( '/^[a-zA-Z\s]+$/', $value );
        });

        //半角英数字チェック
        Validator::extend('alpha_num_half', function($attribute, $value, $parameters, $validator) {

            return preg_match( '/^[a-zA-Z0-9]+$/', $value );
        });

        //半角英数字、ハイフンチェック
        Validator::extend('alpha_num_hyphen_half', function($attribute, $value, $parameters, $validator) {

            return preg_match( '/^[a-zA-Z0-9-]+$/', $value );
        });

        //ひらがなチェック
        Validator::extend('hiragana', function($attribute, $value, $parameters, $validator) {

            mb_regex_encoding("UTF-8");
            return preg_match( '/^[ぁ-んー]+$/u', $value );
        });

        //カタカナチェック
        Validator::extend('katakana', function($attribute, $value, $parameters, $validator) {

            mb_regex_encoding("UTF-8");
            return preg_match( '/^[ァ-ヶー]+$/u', $value );
        });

        //漢字チェック
        Validator::extend('kanji', function($attribute, $value, $parameters, $validator) {

            mb_regex_encoding("UTF-8");
            return preg_match( '/^[一-龠]]+$/u', $value );
        });

        //ISドメイン(@initialsite.com)チェック
        Validator::extend('is_domain', function($attribute, $value, $parameters, $validator) {

            return preg_match( '/@initialsite\.com/', $value );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
