<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class ForceHttps
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->secure() && app()->environment("production") && !$request->is("up") && !$request->is("api/health") && !$request->is("api/metrics")) {
            // only force for the public domain, allow plain IP access
            if ($request->getHost() === "tokensale.linkus1.online") {
                return redirect()->secure($request->getRequestUri(), 301);
            }
        }
        return $next($request);
    }
}
