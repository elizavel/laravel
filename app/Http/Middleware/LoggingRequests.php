<?php

namespace App\Http\Middleware;

use App\Models\Log;
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
        $this->logRequest($request);
        return $next($request);
    }

    private function logRequest($request){
        $log = new Log();
        $uid = 0;
        if($request->has('uid')){
            $uid = $request->input('uid');
        } 
        $log->uid=$uid;
        $log->url=$request->path();
        $log->request=json_encode($request->all());
        $log->save();
    }
}
