<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CommonService;

class AgentController extends Controller
{
    public function createAgent(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $response = CommonService::getUrlResponse($header, $params, "agents", "post");

        return response()->json($response->json());
    }

    public function getAgent(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $response = CommonService::getUrlResponse($header, $params, "agents", "get");

        return response()->json($response->json());
    }
}
