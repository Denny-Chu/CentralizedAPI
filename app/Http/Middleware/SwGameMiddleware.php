<?php

namespace App\Http\Middleware;

use App\Http\Services\CommonService;
use Closure;
use Illuminate\Http\Request;

class SwGameMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->has('username')) {
            return response()->json(['error' => 'Username is required'], 400);
        }

        $result = CommonService::parseUsername($request->input('username'));

        $request->merge([
            'username' => $result['username'],
            'parseData' => [
                'cagent' => $result['cagent'],
                'agent' => $result['agent'],
                'cagent_model' => $result['cagent_model'],
            ]
        ]);

        return $next($request);
    }
}
