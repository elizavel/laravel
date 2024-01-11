<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LogController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoggingRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Logging any requests
        $logController = new LogController(); 
        $logController->logRequest($request);
        return $next($request);
    } 
}
