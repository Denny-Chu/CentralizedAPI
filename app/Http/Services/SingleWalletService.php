<?php

namespace App\Http\Services;

use App\Http\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\SingleWalletRequestRecord;
use App\Models\RequestHeader;
use App\Models\RequestBody;
use App\Models\ResponseRecord;
use App\Models\SingleWalletSet;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class SingleWalletService
{
    public $platform;

    public function handleRequest(Request $request, $method)
    {
        // 轉發請求到目標 API
        $response = $this->forwardRequest($request, $method);

        // 儲存響應記錄
        $this->saveResponseRecord($response, $request->Input('swrr'));

        return $response;
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
