<?php

namespace App\Http\Middleware\Admin\Pastries;

use App\Extenders\BaseMiddleware as Middleware;

class CategoryMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.categories.crud'];
    }
}
