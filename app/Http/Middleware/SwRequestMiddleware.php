<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\SingleWalletRequestRecord;
use App\Models\RequestHeader;
use App\Models\RequestBody;

class SwRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 生成 UUID
        $uuid = Str::uuid();

        // 從路由中獲取方法名
        $method = $this->getMethodFromRoute($request);

        // 保存請求記錄
        $swrr = $this->saveRequestRecord($request, $uuid, $method);

        // 保存請求頭
        $this->saveRequestHeaders($request, $swrr->id);

        // 保存請求體
        $this->saveRequestBody($request, $swrr->id);

        // 將 swrr_id 添加到請求中，以便後續使用
        $request->merge(['swrr_id' => $swrr->id]);

        return $next($request);
    }

    private function getMethodFromRoute(Request $request)
    {
        $route = $request->route();
        if (is_array($route) && isset($route[1]['as'])) {
            return $route[1]['as'];
        }
        return 'unknown';
    }

    private function saveRequestRecord(Request $request, $uuid, $method)
    {
        return SingleWalletRequestRecord::create([
            'uuid' => $uuid,
            'method' => $method,
            'full_request' => json_encode($request->all()),
            'request_method' => $request->method(),
            'request_url' => $request->fullUrl(),
        ]);
    }

    private function saveRequestHeaders(Request $request, $swrrId)
    {
        foreach ($request->headers->all() as $key => $value) {
            RequestHeader::create([
                'swrr_id' => $swrrId,
                'key' => $key,
                'value' => $value[0],
            ]);
        }
    }

    private function saveRequestBody(Request $request, $swrrId)
    {
        foreach ($request->all() as $key => $value) {
            RequestBody::create([
                'swrr_id' => $swrrId,
                'key' => $key,
                'value' => is_array($value) ? json_encode($value) : $value,
            ]);
        }
    }
}