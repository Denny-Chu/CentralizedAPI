<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CommonService;

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

        return response()->json($response->json());
    }

    public function logout(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $hash = hash("SHA256", json_encode($params));

        $response = CommonService::getUrlResponse($header, $params, "logout", "post");


        return response()->json($response->json());
    }

    public function logoutAll(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $hash = hash("SHA256", json_encode($params));

        $response = CommonService::getUrlResponse($header, $params, "logout/all", "post");


        return response()->json($response->json());
    }
}
