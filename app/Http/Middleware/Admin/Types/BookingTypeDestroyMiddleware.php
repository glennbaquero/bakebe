<?php

namespace App\Http\Middleware\Admin\Types;

use Closure;

class BookingTypeDestroyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if (!$user->hasAnyPermission(['admin.types.archive'])) {

            if($request->ajax()) {
                return response(['message' => 'Unauthorized Access'], 401);
            }

            abort(401);
        }

        return $next($request);
    }
}
