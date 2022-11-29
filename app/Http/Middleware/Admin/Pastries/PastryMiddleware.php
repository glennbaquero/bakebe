<?php

namespace App\Http\Middleware\Admin\Pastries;

use App\Extenders\BaseMiddleware as Middleware;

class PastryMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.pastries.crud'];
    }
}
