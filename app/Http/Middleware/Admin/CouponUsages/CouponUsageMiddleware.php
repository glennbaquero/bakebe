<?php

namespace App\Http\Middleware\Admin\CouponUsages;

use App\Extenders\BaseMiddleware as Middleware;

class CouponUsageMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.couponusages.crud'];
    }
}
