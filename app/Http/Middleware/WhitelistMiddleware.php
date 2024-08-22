<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Cagent;
use App\Models\Whitelists;

class WhitelistMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('Authorization');
        $ip = $request->ip();

        $cagent = Cagent::where('api_key', $apiKey)->first();

        if (!$cagent) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        $whitelist = Whitelists::where('cagent_uid', $cagent->uid)
            ->where('ip_address', $ip)
            ->where('is_active', true)
            ->first();

        if (!$whitelist) {
            return response()->json(['error' => 'IP not whitelisted'], 403);
        }

        return $next($request);
    }
}