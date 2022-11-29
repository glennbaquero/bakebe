<?php

namespace App\Http\Middleware\Admin\Coupons;

use App\Extenders\BaseMiddleware as Middleware;

class CouponMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.coupons.crud'];
    }
}
