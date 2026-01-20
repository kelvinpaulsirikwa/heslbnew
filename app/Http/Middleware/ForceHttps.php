<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttps
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
        // Only force in production/staging
        if (!app()->environment('local')) {

            $host = $request->getHost(); // current host
            $uri = $request->getRequestUri(); // path + query string
            $scheme = $request->getScheme(); // http or https

            $shouldRedirect = false;

            // 1. Force HTTPS
            if ($scheme !== 'https') {
                $scheme = 'https';
                $shouldRedirect = true;
            }

            // 2. Force www
            if (!str_starts_with($host, 'www.')) {
                $host = 'www.' . $host;
                $shouldRedirect = true;
            }

            // Redirect if needed
            if ($shouldRedirect) {
                $redirectUrl = $scheme . '://' . $host . $uri;
                return redirect()->to($redirectUrl, 301);
            }
        }

        return $next($request);
    }
}
