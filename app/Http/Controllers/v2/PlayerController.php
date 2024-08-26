<?php

namespace App\Http\Controllers\v2;

use Illuminate\Http\Request;
use App\Http\Services\CommonService;
use Illuminate\Support\Facades\Http;


class PlayerController extends Controller
{
    public function createPlayer(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        // --------------------
        $game = $params['game'];
        if ($game === 'LOTTO') {
            $response = CommonService::getUrlResponse($header, $params, "players", "post", true);
        } else {
            $platform = $params['platform'];
            $hash = hash("SHA256", json_encode($params));
            $response = Http::withHeaders($header)->post(env(strtoupper($game) . '_V2_API_URL') . "/$platform/players?hash=$hash", $params);
        }

        return response()->json($response->json());
    }

    public function playerStatus(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $response = CommonService::getUrlResponse($header, $params, "players/status", "get", true);

        return response()->json($response->json());
    }

    public function onlinePlayersList(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $response = CommonService::getUrlResponse($header, $params, "players/online", "get", true);

        return response()->json($response->json());
    }
}
