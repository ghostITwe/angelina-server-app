<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkDatabase
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
        if ($request->hasHeader('database') && !empty($request->header('database'))) {
            $values = config('database.databases.'.$request->header('database'));
            env('DB_DATABASE', $values['database']);
            env('DB_USERNAME', $values['username']);
            env('DB_PASSWORD', $values['password']);
        }
    }
}
