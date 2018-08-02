<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/', 'ajax/*','search/*','item/register/*','item/edit',
        'item/article_register', 'item/sale/register2',
        'item/sale/register3','item/sale/register4',
    ];
}
