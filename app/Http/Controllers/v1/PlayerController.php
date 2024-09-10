<?php

namespace App\Http\Controllers\v1;

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
            $response = CommonService::getUrlResponse($header, $params, "players", "post");
        } else {
            $platform = $params['platform'];
            $hash = hash("SHA256", json_encode($params));
            $response = Http::withHeaders($header)->post(env(strtoupper($game) . '_API_URL') . "/$platform/players?hash=$hash", $params);
        }

        return response()->json($response->json());
    }

    public function playerStatus(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $response = CommonService::getUrlResponse($header, $params, "players/status", "get");

        return response()->json($response->json());
    }

    public function onlinePlayersList(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $response = CommonService::getUrlResponse($header, $params, "players/online", "get");

        return response()->json($response->json());
    }

    public function transfer(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $game = $params['game'];

        if ($game === "LOTTO") {
            $response = CommonService::getUrlResponse($header, $params, "transfer", "post");
        } else {
            $platform = $params['platform'];
            $hash = hash("SHA256", json_encode($params));
            $response = Http::withHeaders($header)->post(env(strtoupper($game) . '_API_URL') . "/$platform/transfer?hash=$hash", $params);
        }

        return response()->json($response->json());
    }

    public function getMoney(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $game = $params['game'];

        if ($game === "LOTTO") {
            $response = CommonService::getUrlResponse($header, $params, "players/getMoney", "get");
        } else {
            $platform = $params['platform'];
            $hash = hash("SHA256", json_encode($params));
            $response = Http::withHeaders($header)->post(env(strtoupper($game) . '_API_URL') . "/$platform/players/getMoney?hash=$hash", $params);
        }

        return response()->json($response->json());
    }
}
