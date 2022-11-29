<?php

namespace App\Http\Middleware\Admin\Types;

use App\Extenders\BaseMiddleware as Middleware;

class BookingTypeMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.types.crud'];
    }
}