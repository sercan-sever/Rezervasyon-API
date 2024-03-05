<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotLoginPageShow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return auth()->guard('api')->check()
            ? response()->json(['success' => false, 'message' => "Giriş Yapmış Olduğunuz İçin Bu Sayfaya Erişiminiz Yok !!!"], Response::HTTP_FORBIDDEN)
            : $next($request);
    }
}
