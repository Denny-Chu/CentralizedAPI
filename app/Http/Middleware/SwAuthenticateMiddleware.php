<?php

namespace App\Http\Middleware;

use App\Http\Services\CommonService;
use Closure;
use Illuminate\Http\Request;

class SwAuthenticateMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $platform = $request->input('platform');
        $username = $request->input('username');
        $agentName = $request->input('agentName');

        if (!$platform) {
            return $this->errorResponse(8001, 'Platform parameter is missing');
        }

        if (!$username) {
            return $this->errorResponse(8001, 'Username parameter is missing');
        }

        if (!$agentName) {
            return $this->errorResponse(8001, 'AgentName parameter is missing');
        }

        // 驗證參數長度
        if (strlen($platform) > 15 || strlen($username) > 15 || strlen($agentName) > 15) {
            return $this->errorResponse(8010, 'Parameter is too long');
        }

        // 驗證參數格式（例如：只允許字母和數字）
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            return $this->errorResponse(7603, 'Invalid username');
        }

        // 重組 username
        $newUsername = "{$platform}_{$agentName}_{$username}";
        $request->merge(['username' => $newUsername]);

        return $next($request);
    }

    /**
     * Return a JSON error response.
     *
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    private function errorResponse($code, $message)
    {
        return response()->json([
            'code' => $code,
            'success' => false,
            'error' => $message
        ], 400);
    }
}
