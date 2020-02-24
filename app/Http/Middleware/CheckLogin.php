<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //if ($request->age <= 200) {

        $url = $request->url();
        if (strpos($url, 'office/password') !== false) {
            return $next($request);
        }

        if (strpos($url, 'welcome') !== false) {
            return $next($request);
        }

        if (strpos($url, 'test') !== false) {
            return $next($request);
        }

        if (Session::get('user_id') == null  || Session::get('user_id') == "") {            
            return redirect('login');
        }

        return $next($request);
    }
}
