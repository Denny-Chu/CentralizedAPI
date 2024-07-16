<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CommonService;

class PlayerController extends Controller
{
    public function createPlayer(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        // $hash = hash("SHA256", json_encode($params));
        // $response = CommonService::getUrlResponse($header, $params, "players?hash=$hash", "post");
        $response = CommonService::getUrlResponse($header, $params, "players", "post");

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
}
