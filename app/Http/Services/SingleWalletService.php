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

class SingleWalletService
{
    public $platform;

    public function handleRequest(Request $request, $method)
    {
        // 生成 UUID
        $uuid = Str::uuid();

        // 儲存請求記錄
        $swrr = $this->saveRequestRecord($request, $uuid, $method);

        // 儲存請求標頭
        $this->saveRequestHeaders($request, $swrr->id);

        // 儲存請求內容
        $this->saveRequestBody($request, $swrr->id);

        // 轉發請求到目標 API
        $response = $this->forwardRequest($request, $method);

        // 儲存響應記錄
        $this->saveResponseRecord($response, $swrr->id);

        return $response;
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

    private function forwardRequest(Request $request, $gameMethod)
    {
        $targetUrl = $this->getCallBackUrl($request->input('cagent_model')->uid, $this->platform, $gameMethod);
        if($targetUrl === null){
            throw new Exception('Undefined merchant with invalid callback url');
        }

        $method = strtolower($request->method());
        $options = [
            'headers' => $request->headers->all(),
            'body' => $request->getContent(),
        ];

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
