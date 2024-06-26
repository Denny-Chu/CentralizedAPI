<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlayerController extends Controller
{
    public function createPlayer(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $game = $params['game'];
        $platform = $params['platform'];

        $hash = hash("SHA256", json_encode($params));

        $response = Http::withHeaders($header)->post(env(strtoupper($game) . '_API_URL') . "/$platform/players?hash=$hash", $params);

        return response()->json($response->json());
    }

    public function playerStatus(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $game = $params['game'];
        $platform = $params['platform'];

        $hash = hash("SHA256", http_build_query($params));
        $params['hash']  = $hash;

        $response = Http::withHeaders($header)->get(env(strtoupper($game) . '_API_URL') . "/$platform/players/status", $params);

        return response()->json($response->json());
        
    }

    public function onlinePlayersList(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $game = $params['game'];
        $platform = $params['platform'];

        $hash = hash("SHA256", http_build_query($params));
        $params['hash']  = $hash;

        $response = Http::withHeaders($header)->get(env(strtoupper($game) . '_API_URL') . "/$platform/players/online", $params);

        return response()->json($response->json());
        
    }
}
