<?php

namespace App\Http\Middleware\Admin\Hows;

use App\Extenders\BaseMiddleware as Middleware;

class HowMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.hows.crud'];
    }
}
