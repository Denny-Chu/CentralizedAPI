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
        $ip = $this->getRealIpAddr();

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

    protected function getRealIpAddr()
    {
        $headers = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ip = trim(explode(",", $_SERVER[$header])[0]);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }

        return request()->ip(); // 如果所有方法都失敗，回退到 Laravel 的方法
    }
}
