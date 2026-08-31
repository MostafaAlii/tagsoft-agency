<?php
declare(strict_types=1);
namespace Core\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
class JwtGuardMiddleware {
    public function handle(Request $request, Closure $next, string $guard): Response {
        auth()->shouldUse($guard);
        JWTAuth::parseToken()->authenticate();
        return $next($request);
    }
}