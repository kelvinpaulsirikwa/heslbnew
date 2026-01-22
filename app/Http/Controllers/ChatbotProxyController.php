<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotProxyController extends Controller
{
    private const CHATBOT_BACKEND_URL = 'https://chatbotbackend.heslb.go.tz';
    
    /**
     * Proxy requests to chatbot backend
     */
    public function proxy(Request $request, $path = '')
    {
        $url = self::CHATBOT_BACKEND_URL . '/' . ltrim($path, '/');
        
        // Log the proxy request for debugging
        Log::info("Chatbot proxy request", [
            'method' => $request->method(),
            'url' => $url,
            'query' => $request->query(),
            'has_body' => $request->hasHeader('Content-Type')
        ]);
        
        try {
            // Prepare the HTTP request
            $httpRequest = Http::timeout(30);
            
            // Add headers (excluding host-related headers)
            foreach ($request->headers as $key => $value) {
                if (!in_array(strtolower($key), ['host', 'content-length'])) {
                    $httpRequest = $httpRequest->withHeaders([$key => $value[0]]);
                }
            }
            
            // Make the request based on method
            $response = match ($request->method()) {
                'GET' => $httpRequest->get($url, $request->query()),
                'POST' => $httpRequest->post($url, $request->json()),
                'PUT' => $httpRequest->put($url, $request->json()),
                'DELETE' => $httpRequest->delete($url, $request->json()),
                'OPTIONS' => $httpRequest->options($url),
                default => $httpRequest->get($url, $request->query())
            };
            
            // Log response status
            Log::info("Chatbot proxy response", [
                'status' => $response->status(),
                'successful' => $response->successful()
            ]);
            
            // Return the response with proper headers
            return response($response->body(), $response->status())
                ->withHeaders([
                    'Content-Type' => $response->header('Content-Type') ?? 'application/json',
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
                    'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
                ]);
                
        } catch (\Exception $e) {
            Log::error("Chatbot proxy error", [
                'error' => $e->getMessage(),
                'url' => $url,
                'method' => $request->method()
            ]);
            
            return response()->json([
                'error' => 'Proxy request failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
