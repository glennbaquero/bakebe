<?php

namespace App\Http\Middleware\Admin\Promos;

use App\Extenders\BaseMiddleware as Middleware;

class PromoMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.coupons.crud'];
    }
}
