<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SeminarKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $key = $request->header('apikey');
        if (!$key) {
            return response()->json([
                'status' => 'error',
                'key' => $key,
                'message' => 'API key is required',
            ]);
        }
        if (config('app.key') !== $key) {
            return response()->json([
                'status' => 'error',
                'key' => $key,
                'message' => 'Invalid API key',
            ]);
        }
        return $next($request);
    }
}
