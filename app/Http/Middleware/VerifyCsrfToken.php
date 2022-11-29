<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/*',
        'payment/paymaya',
        'prx_paypal/notify_url',
        '/payment/success',
        'checkout/processPaynamics',
        'checkout/paynamicsReturn',
        'checkout/paynamicsCancel',
        'payment/paymaya/callback-success',
        'payment/paymaya/callback-failure',
        'payment/paymaya/callback-dropout',
        'dashboard'
    ];
}
