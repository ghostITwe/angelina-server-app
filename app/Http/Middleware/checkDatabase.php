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
            $values = config('usersDatabase.'.$request->header('database'));
            config([
                'database.connections.mysql.host' => $values['host'],
                'database.connections.mysql.database' => $values['database'],
                'database.connections.mysql.username' => $values['username'],
                'database.connections.mysql.password' => $values['password'],
            ]);
        }
        return  $next($request);
    }
}
