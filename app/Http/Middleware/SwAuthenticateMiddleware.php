<?php

namespace App\Http\Middleware;

use App\Http\Services\CommonService;
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

        $result = CommonService::parseUsername($request->input('username'));

        $request->merge([
            'cagent' => $result['cagent'],
            'agent' => $result['agent'],
            'username' => $result['username'],
            'cagent_model' => $result['cagent_model'],
        ]);

        return $next($request);
    }
}
