<?php

namespace App\Http\Controllers\v2;

use Illuminate\Http\Request;
use App\Http\Services\CommonService;
use Illuminate\Support\Facades\Http;

class AgentController extends Controller
{
    // public function createAgent(Request $request)
    // {
    //     $params = $request->all();
    //     $header['authorization'] = $request->header('authorization');
    //     // ---
    //     $game = $params['game'];
    //     if ($game === "LOTTO") {
    //         $response = CommonService::getUrlResponse($header, $params, "agents", "post");
    //     } else {
    //         $platform = $params['platform'];
    //         $hash = hash("SHA256", json_encode($params));
    //         $response = Http::withHeaders($header)->post(env(strtoupper($game) . '_V2_API_URL') . "/$platform/agents?hash=$hash", $params);
    //     }

    //     return response()->json($response->json());
    // }

    public function getAgent(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $response = CommonService::swGetUrlResponse($header, $params, "agents", "get");

        return response()->json($response->json());
    }
}
