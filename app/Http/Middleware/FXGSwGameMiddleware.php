<?php

namespace App\Http\Middleware;

use App\Http\Services\CommonService;
use Closure;
use Illuminate\Http\Request;

class FXGSwGameMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->has('Username')) {
            return response()->json(['error' => 'Username is required'], 400);
        }

        $result = CommonService::parseUsername($request->input('Username'));

        $request->merge([
            'Username' => $result['username'],
            'parseData' => [
                'cagent' => $result['cagent'],
                'agent' => $result['agent'],
                'cagent_model' => $result['cagent_model'],
            ]
        ]);

        $app = app();
        $app->instance('Username', $request->input('Username'));

        return $next($request);
    }
}
