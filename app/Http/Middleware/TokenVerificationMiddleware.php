<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\jwt\JWTToken;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('token');
        $result = JWTToken::VerifyToken($token);
        if($result == 'Unauthorized'){
            return response()->json([
                'status'=>'failed',
                'message'=>'Unauthorized'
            ],200);
        }else{
            $request->headers->set('userEmail', $result);
            $request->headers->set('userId', $result);
            return $next($request);
        }

    }
}
