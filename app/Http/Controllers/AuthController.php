<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function demoLogin(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $game = $params['game'];
        $platform = $params['platform'];

        $hash = hash("SHA256", http_build_query($params));
        $params['hash']  = $hash;


        $response = Http::withHeaders($header)->get(env(strtoupper($game) . '_API_URL') . "/$platform/demo/login", $params);

        return response()->json($response->json());
    }


    public function login(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $game = $params['game'];
        $platform = $params['platform'];

        $hash = hash("SHA256", http_build_query($params));
        $params['hash']  = $hash;

        $response = Http::withHeaders($header)->get(env(strtoupper($game) . '_API_URL') . "/$platform/login", $params);

        return response()->json($response->json());

    }

    public function logout(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $game = $params['game'];
        $platform = $params['platform'];

        $hash = hash("SHA256", json_encode($params));

        $response = Http::withHeaders($header)->post(env(strtoupper($game) . '_API_URL') . "/$platform/logout?hash=$hash", $params);

        return response()->json($response->json());
    }

    public function logoutAll(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $game = $params['game'];
        $platform = $params['platform'];

        $hash = hash("SHA256", json_encode($params));

        $response = Http::withHeaders($header)->post(env(strtoupper($game) . '_API_URL') . "/$platform/logout/all?hash=$hash", $params);

        return response()->json($response->json());
    }
}
