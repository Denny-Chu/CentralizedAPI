<?php

namespace App\Http\Controllers\v1;

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
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $response = CommonService::getUrlResponse($header, $params, "login", "get");

        if ($response->ok()) {
            $url = $response->object()->data->Url;
            $fakeRequest = Request::create($url);
            $queryParams = $fakeRequest->query();
            MemberInfo::where('memId', $queryParams['username'])->update(['passwd' => $queryParams['token']]);
        }

        return response()->json($response->json());
    }

    public function logout(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $game = $params['game'];

        if ($game === "LOTTO") {
            $response = CommonService::getUrlResponse($header, $params, "logout", "post");
        } else {
            $platform = $params['platform'];
            $hash = hash("SHA256", json_encode($params));
            $response = Http::withHeaders($header)->post(env(strtoupper($game) . '_API_URL') . "/$platform/logout?hash=$hash", $params);
        }

        return response()->json($response->json());
    }

    public function logoutAll(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $game = $params['game'];
        if ($game === "LOTTO") {
            $response = CommonService::getUrlResponse($header, $params, "logout/all", "post");
        } else {
            $platform = $params['platform'];
            $hash = hash("SHA256", json_encode($params));
            $response = Http::withHeaders($header)->post(env(strtoupper($game) . '_API_URL') . "/$platform/logout/all?hash=$hash", $params);
        }

        return response()->json($response->json());
    }
}
