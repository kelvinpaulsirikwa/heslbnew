<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotProxyController extends Controller
{
    public function proxy(Request $request, $path = '')
    {
        $url = 'https://chatbotbackend.heslb.go.tz/' . ltrim($path, '/');
        
        $response = Http::timeout(30)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->send($request->method(), $url, [
                'query' => $request->query(),
                'json' => $request->json(),
            ]);
        
        return response($response->body(), $response->status())
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
            ]);
    }
}
