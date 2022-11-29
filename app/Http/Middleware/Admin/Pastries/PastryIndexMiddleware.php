<?php

namespace App\Http\Middleware\Admin\Pastries;

use Closure;

class PastryIndexMiddleware
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

        if (!$user->hasAnyPermission(['admin.pastries.index'])) {

            if($request->ajax()) {
                return response(['message' => 'Unauthorized Access'], 401);
            }

            abort(401);
        }

        return $next($request);
    }
}
