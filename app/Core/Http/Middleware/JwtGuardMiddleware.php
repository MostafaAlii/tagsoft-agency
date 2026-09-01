<?php

declare(strict_types=1);

namespace Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JwtGuardMiddleware
{
    public function handle(Request $request, Closure $next, string $guard): Response {
        try {
            $token = JWTAuth::parseToken()->getToken();
            if (!$token) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized - No token provided'
                ], 401);
            }

            $payload = JWTAuth::getPayload($token);
            $tokenGuard = $payload->get('guard');
            if ($tokenGuard !== $guard) {
                return response()->json([
                    'status' => false,
                    'message' => "Unauthorized - Token issued for guard '{$tokenGuard}', not for '{$guard}'"
                ], 401);
            }

            auth()->shouldUse($guard);
            if (!auth()->guard($guard)->check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized - User not found'
                ], 401);
            }
        } catch (TokenExpiredException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized - Token expired'
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized - Token invalid'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized - ' . $e->getMessage()
            ], 401);
        }
        return $next($request);
    }
}