<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ResponseRecord;
use App\Models\SingleWalletSet;
use Exception;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SingleWalletService
{
    public $platform;

    public function handleRequest(Request $request, $method, $fullUsername)
    {
        // 轉發請求到目標 API
        $response = $this->forwardRequest($request, $method);

        // 儲存響應記錄
        $this->saveResponseRecord($response, app('swrr_id'));

        $response = $this->rebuildResponse($response, $fullUsername);

        return response()->json($response);
    }

    private function forwardRequest(Request $request, $gameMethod)
    {
        $targetUrl = $this->getCallBackUrl(request('parseData')['cagent_model']['uid'] ?? null, $this->platform, $gameMethod);
        if ($targetUrl === null) {
            throw new Exception('Undefined merchant with invalid callback url');
        }
        $clone = clone $request;
        unset($clone['parseData']);
        $method = strtolower($request->method());

        $allowedHeaders = [
            'user-agent',
            'accept',
            'accept-encoding',
            'accept-language',
            'content-type',
            'x-forwarded-for',
            'x-real-ip',
        ];

        // 從原始請求中獲取頭信息並過濾
        $headers = collect($request->headers->all())
            ->filter(function ($value, $key) use ($allowedHeaders) {
                return in_array(strtolower($key), $allowedHeaders);
            })
            ->map(function ($item) {
                return $item[0]; // Laravel 的 headers->all() 返回的是數組，我們只需要第一個值
            })
            ->all();

        return Http::withHeaders($headers)->$method("{$targetUrl}?hash={$request->input('hash')}", $clone->json()->all());
    }

    private function saveResponseRecord($response, $swrrId)
    {
        ResponseRecord::create([
            'swrr_id' => $swrrId,
            'status_code' => $response->status(),
            'headers' => json_encode($response->headers()),
            'body' => $response->body(),
        ]);
    }

    public function getCallBackUrl($cagentUid, $platform, $method)
    {
        return SingleWalletSet::where(['cagent_uid' => $cagentUid, 'platform' => $platform, 'method' => $method])->first()->callback_url;
    }

    public function rebuildResponse(ClientResponse $response, string $fullUsername)
    { 
        $content = $response->json(); // 獲取 response 的 JSON 內容作為數組
        // 現在修改內容
        $content = array_merge($content, ['username' => $fullUsername]);
        // 創建一個新的 response 對象，包含修改後的內容
        return $content;
    }
}
