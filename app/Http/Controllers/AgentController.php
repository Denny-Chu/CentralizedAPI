<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AgentController extends Controller
{
    public function createAgent(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $game = $params['game'];
        $platform = $params['platform'];

        $hash = hash("SHA256", json_encode($params));

        $response = Http::withHeaders($header)->post(env(strtoupper($game) . '_API_URL') . "/$platform/agents?hash=$hash", $params);

        return response()->json($response->json());
        
    }

    public function getAgent(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $game = $params['game'];
        $platform = $params['platform'];

        $hash = hash("SHA256", http_build_query($params));
        $params['hash']  = $hash;

        $response = Http::withHeaders($header)->get(env(strtoupper($game) . '_API_URL') . "/$platform/agents", $params);

        return response()->json($response->json());
        
    }
}
