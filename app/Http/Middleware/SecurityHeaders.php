<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        /*
        |--------------------------------------------------------------------------
        | Clickjacking Protection
        |--------------------------------------------------------------------------
        */
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        /*
        |--------------------------------------------------------------------------
        | Content Security Policy (CSP)
        |--------------------------------------------------------------------------
        | NOTE:
        | - 'unsafe-eval' is required for CKEditor
        | - 'unsafe-inline' is allowed for legacy scripts/styles
        | - unpkg.com added for dotlottie-player
        | - chatbot backend added for API calls
        */
        $cspDirectives = [
            "default-src 'self'",

            "script-src 'self' 'unsafe-inline' 'unsafe-eval'
                https://cdn.jsdelivr.net
                https://cdnjs.cloudflare.com
                https://cdn.bootstrapcdn.com
                https://unpkg.com
                https://chatbot.heslb.go.tz",

            "style-src 'self' 'unsafe-inline'
                https://cdn.jsdelivr.net
                https://cdnjs.cloudflare.com
                https://cdn.bootstrapcdn.com
                https://fonts.googleapis.com
                https://chatbot.heslb.go.tz",

            "font-src 'self' data:
                https://cdn.jsdelivr.net
                https://cdnjs.cloudflare.com
                https://cdn.bootstrapcdn.com
                https://fonts.gstatic.com
                https://chatbot.heslb.go.tz",

            "img-src 'self' data: blob: https: http:
                https://chatbot.heslb.go.tz",

            "connect-src 'self'
                https://chatbot.heslb.go.tz
                https://chatbotbackend.heslb.go.tz
                https://lottie.host
                https://cdn.jsdelivr.net
                https://unpkg.com",

            "frame-src 'self'
                https://chatbot.heslb.go.tz",

            "frame-ancestors 'self'",

            "object-src 'none'",

            "base-uri 'self'",

            "form-action 'self'",

            // Uncomment ONLY when SSL is fully correct
            // "upgrade-insecure-requests"
        ];

        // Normalize CSP into a single line
        $cspHeader = preg_replace('/\s+/', ' ', implode('; ', $cspDirectives));
        $response->headers->set('Content-Security-Policy', trim($cspHeader));

        /*
        |--------------------------------------------------------------------------
        | Additional Security Headers
        |--------------------------------------------------------------------------
        */
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Deprecated but safe to keep for legacy browsers
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Prevent debugging in production (optional)
        if (app()->environment('production')) {
            $response->headers->set('Content-Security-Policy', $cspHeader . '; script-src-eval false');
        }

        /*
        |--------------------------------------------------------------------------
        | HTTP Strict Transport Security (HSTS)
        |--------------------------------------------------------------------------
        | Enable ONLY when SSL is valid and stable
        */
        // if ($request->secure() && app()->environment('production')) {
        //     $response->headers->set(
        //         'Strict-Transport-Security',
        //         'max-age=31536000; includeSubDomains; preload'
        //     );
        // }

        return $response;
    }
}
