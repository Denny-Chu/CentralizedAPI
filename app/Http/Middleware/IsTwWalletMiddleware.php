<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Cagent;

class IsTwWalletMiddleware
{
    public function handle($request, Closure $next)
    {
        $authHeader = $request->header('authorization');
        $cagent = Cagent::where('api_key_sw', $authHeader)->first();
        
        if ($cagent && $cagent->is_sw == 1) {
            return response()->json(['msg' => 'wallet type is forbidden'], 403);
        }

        return $next($request);
    }
}