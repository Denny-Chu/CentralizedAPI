<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
// Service
use App\Http\Services\LottoService;
use App\Models\Cagent;
use App\Models\SingleWalletSet;
use Exception;

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
    public static function getUrlResponse($header, $params, $route, $method, $IsSingleWallet = false)
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
                $url = $IsSingleWallet
                    ? env(strtoupper($game) . '_V2_API_URL') . "/$platform/$route"
                    : env(strtoupper($game) . '_API_URL') . "/$platform/$route";
                $response = Http::withHeaders($header)->$method($url, $params);
                break;
        }

        return $response;
    }

    public static function parseUsername($username): array
    {

        $parts = explode('_', $username, 3);
        if (count($parts) < 3) {
            throw new Exception('Invalid username format', 400);
        }

        $cagent = Cagent::where('cagent', $parts[0])->first();
        if (!$cagent) {
            throw new Exception('Invalid cagent', 401);
        }

        return [
            'cagent' => $parts[0],
            'agent' => $parts[1],
            'username' => implode('_', array_slice($parts, 2)), // 原本username被用底線分割成多個參數，現在將第三個參數後的所有參數用底線連結回來組回名稱
            'cagent_model' => $cagent
        ];
    }
}
