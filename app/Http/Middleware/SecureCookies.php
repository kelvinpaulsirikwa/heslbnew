<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureCookies
{
    /**
     * Handle an incoming request.
     *
     * Ensures all cookies have Secure + HttpOnly flags in non-local environments.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Determine if we should process cookies based on security requirements
        $isProduction = app()->environment('production');
        $appUrlIsHttps = str_starts_with(env('APP_URL', ''), 'https://');
        $shouldProcess = $request->secure() || app()->environment('local') || ($isProduction && $appUrlIsHttps);
        
        // Enforce Secure + HttpOnly for all cookies when using HTTPS
        // In local environment, allow HTTP cookies for development
        // In production, this prevents session hijacking and cookie theft
        // NOTE: In production, we process cookies if:
        // 1. Request is secure (HTTPS), OR
        // 2. We're in local environment, OR  
        // 3. APP_URL uses https (production environment) - handles proxy cases
        
        if ($shouldProcess) {
            $cookies = $response->headers->getCookies();

            foreach ($cookies as $cookie) {
                $sameSite = $cookie->getSameSite() ?: 'Lax';

                // Remove original cookie
                $response->headers->removeCookie(
                    $cookie->getName(),
                    $cookie->getPath(),
                    $cookie->getDomain()
                );

                // Re-add cookie with secure + HttpOnly
                $newCookie = cookie(
                    $cookie->getName(),
                    $cookie->getValue(),
                    $cookie->getExpiresTime() / 60, // minutes
                    $cookie->getPath(),
                    $cookie->getDomain(),
                    true,   // Always enforce Secure
                    true,   // Enforce HttpOnly for all cookies
                    false,  // raw
                    $sameSite
                );
                
                $response->headers->setCookie($newCookie);
            }
        }

        return $response;
    }
}
