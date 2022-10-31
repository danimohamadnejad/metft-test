<?php

namespace Metft\FeedReader\Http\Middlewares;
use Closure;
use Illuminate\Http\Request;

class SetAppLocaleMiddleware
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
        $locale_key = feed_reader_get_app_locale_key();
        $locale_value = $request->input($locale_key);
        if(!empty($locale_value)){
            app()->setLocale($locale_value);
        }
        return $next($request);
    }
}
