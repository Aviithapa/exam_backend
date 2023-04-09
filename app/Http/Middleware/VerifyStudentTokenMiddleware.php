<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyStudentTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Check if the request has a token
        if (!$request->hasHeader('Authorization')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get the token from the request header
        $token = $request->header('Authorization');

        // Access the "symbol_number" from the decoded token
        // $symbolNumber = $decodedToken->get('symbol_number');
        try {
            // Attempt to decode the token
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // If the token is valid, continue to the next middleware or route
        return $next($request);
    }
}
