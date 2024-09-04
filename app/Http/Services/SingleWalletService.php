<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ResponseRecord;
use App\Models\SingleWalletSet;
use Exception;
use Illuminate\Support\Facades\DB;

class SingleWalletService
{
    public $platform;

    public function handleRequest(Request $request, $method)
    {
        // 轉發請求到目標 API
        // $response = $this->forwardRequest($request, $method);

        // 儲存響應記錄
        // $this->saveResponseRecord($response, $request->Input('swrr'));

        // 測試用回應，先將資料順利跑一遍
        switch ($method) {
            case "auth":
                $response = [
                    'username' => '911_tgs_tgs208482',
                    'currency' => 'PHP',
                    'balance' => '99999999',
                ];
                break;
            case "balance":
            case "bet":
            case "cancelBet":
            default:
                $response = [
                    'balance' => '99999999',
                ];
                break;
        }

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
        $options = [
            'headers' => $request->headers->all(),
            'body' => $clone->getContent(),
        ];
        DB::commit();
        return Http::withOptions($options)->$method($targetUrl);
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
}
