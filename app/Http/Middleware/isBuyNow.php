<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isBuyNow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Danh sách các route cần loại trừ
        $excludedRoutes = [
            'carts.thanh-toan',
            'carts.checkout',
            'carts.api.districts',
            'carts.api.wards',
            'auth.login',
            'auth.authenticate',
            'auth.register',
            'auth.google-auth',
            'auth.callbackGoogle',
        ];

        // Nếu route hiện tại nằm trong danh sách loại trừ, bỏ qua middleware
        if ($request->routeIs($excludedRoutes)) {
            return $next($request);
        }

        // Nếu session tồn tại và không thuộc các route trên, xóa session
        if (session()->has('buy_now')) {
            session()->forget('buy_now');
        }

        return $next($request);
    }
}
