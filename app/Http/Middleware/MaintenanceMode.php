<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        // لو الصيانة شغالة
        if (env('MAINTENANCE_MODE') === 'true') {

            // ✅ استثناء الأدمن والروت الخاص بتبديل الصيانة
            if (
                $request->is('admin*') ||   // أى لينك يبدأ بـ admin
                $request->is('backend*') || // أى لينك يبدأ بـ backend
                $request->is('login') ||
                $request->is('logout')
            ) {
                return $next($request);
            }

            // ✅ عرض صفحة الصيانة
            return response()->view('include.error');
        }

        return $next($request);
    }
}
