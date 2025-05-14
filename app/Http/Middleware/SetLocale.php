<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        } else {
            // Default locale from config
            $locale = config('app.locale');
            Session::put('locale', $locale);
        }
        
        // Set the application locale
        App::setLocale($locale);
        
        // Set the direction for RTL languages
        if ($locale === 'ar') {
            Session::put('direction', 'rtl');
        } else {
            Session::put('direction', 'ltr');
        }
        
        return $next($request);
    }
}
