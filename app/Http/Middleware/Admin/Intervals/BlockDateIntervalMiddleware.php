<?php

namespace App\Http\Middleware\Admin\Intervals;

use App\Extenders\BaseMiddleware as Middleware;

class BlockDateIntervalMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.intervals.crud'];
    }
}
