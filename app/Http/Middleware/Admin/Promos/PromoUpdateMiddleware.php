<?php

namespace App\Http\Middleware\Admin\Promos;

use Closure;

class PromoUpdateMiddleware
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

        if (!$user->hasAnyPermission(['admin.promos.show'])) {

            if($request->ajax()) {
                return response(['message' => 'Unauthorized Access'], 401);
            }

            abort(401);
        }

        return $next($request);
    }
}
