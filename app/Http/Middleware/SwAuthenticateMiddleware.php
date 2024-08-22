<?php

namespace App\Http\Middleware;

use App\Models\Cagent;
use Closure;
use Illuminate\Http\Request;

class SwAuthenticateMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->has('username')) {
            return response()->json(['error' => 'Username is required'], 400);
        }

        $parts = explode('_', $request->input('username'), 3);
        if (count($parts) < 3) {
            return response()->json(['error' => 'Invalid username format'], 400);
        }

        $cagent = Cagent::where('cagent', $parts[0])->first();
        if (!$cagent) {
            return response()->json(['error' => 'Invalid cagent'], 401);
        }

        $request->merge([
            'cagent' => $parts[0],
            'agent' => $parts[1],
            'username' => implode('_', array_slice($parts, 2)), // 原本username被用底線分割成多個參數，現在將第三個參數後的所有參數用底線連結回來組回名稱
            'cagent_model' => $cagent
        ]);
        
        

        return $next($request);
    }
}
