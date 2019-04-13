<?php
namespace AutoApiServer\Api\ApiServer\Auto\Middleware;

use Closure;
use Illuminate\Http\Request;

class TestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->table == "demo") {
            return response("no");
        }

        return $next($request);
    }
}
