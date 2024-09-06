<?php

namespace App\Http\Controllers\v2;

use Illuminate\Http\Request;
use App\Http\Services\CommonService;
use App\Models\MemberInfo;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function demoLogin(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $response = CommonService::getUrlResponse($header, $params, "demo/login", "get");

        return response()->json($response->json());
    }


    public function login(Request $request)
    {
        $params = [
            'username' => $request->input('username'),
            'gameID' => $request->input('gameID', 'mega'),
            'agentName' => $request->input('agentName'),
            'lang' => $request->input('lang', 'en'),
            'homeURL' => $request->input('homeURL'),
            'token' => $request->input('token'),
        ];
        $response = CommonService::swGetUrlResponse($request, $params, "login", "get");

        if ($response->ok()) {
            MemberInfo::where('memId', $params['username'])->update(['passwd' => $request->input('token')]);
        }

        return response()->json($response->json());
    }

    public function logout(Request $request)
    {
        $params = $request->all();
        
        $response = CommonService::swGetUrlResponse($request, $params, "logout", "post");

        return response()->json($response->json());
    }
}
