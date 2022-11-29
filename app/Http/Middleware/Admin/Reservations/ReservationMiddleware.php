<?php

namespace App\Http\Middleware\Admin\Reservations;

use App\Extenders\BaseMiddleware as Middleware;

class ReservationMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.bookings.crud'];
    }
}
