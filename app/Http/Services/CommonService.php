<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
// Service
use App\Http\Services\LottoService;
use App\Models\SingleWalletSet;

class CommonService extends Service
{

    public function dealRequest(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $hash = hash("SHA256", http_build_query($params));
        $params['hash']  = $hash;

        return $params;
    }

    /**
     * 轉接api後取得回應
     */
    public static function getUrlResponse($header, $params, $route, $method)
    {
        $game = $params['game'];
        $platform = $params['platform'];

        switch ($game) {
            case "LOTTO":
                $route = LottoService::getLottoRoute($route); //轉換一下
                $params['hash'] = LottoService::getLottoHash($params);
                $response = Http::withHeaders($header)->$method(env(strtoupper($game) . '_API_URL') . "/$route", $params);
                break;
            default:
                $hash = hash("SHA256", http_build_query($params));
                $params['hash']  = $hash;
                $response = Http::withHeaders($header)->$method(env(strtoupper($game) . '_API_URL') . "/$platform/$route", $params);
                break;
        }

        return $response;
    }

    public static function getCallBackUrl($cagentUid, $platform, $method)
    {
        $url = '';

        $url = SingleWalletSet::where(['cagent_uid' => $cagentUid, 'platform' => $platform, 'method' => $method])->first()->pluck('callback_url');

        return $url;
    }
}
