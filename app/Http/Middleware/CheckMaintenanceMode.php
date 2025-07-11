<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $maintenanceMode = DB::table('sgo_config')
            ->value('maintenance_mode');

        if ($maintenanceMode) {
            // Bỏ qua trang admin hoặc API nếu cần
            if (
                $request->is('admin') || $request->is('admin/*') ||
                $request->is('api') || $request->is('api/*')
            ) {
                return $next($request);
            }

            return response()->view('maintenance');
        }

        return $next($request);
    }
}
