<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        \Log::info('AdminMiddleware Check', [
            'authenticated' => auth()->check(),
            'user_id' => auth()->id(),
            'is_admin' => auth()->user()->is_admin ?? 'no user'
        ]);

        

        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized access');
        }
        return $next($request);
    }
}
