<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $user = $request->user();

        if ($user && $user->can($permission) ) {
            return $next($request);
        }
        return $request->expectsJson()
            ? response()->json(['message' => 'Không có quyền!'], 403)
            : abort(403, 'Không có quyền!');
    }
}
