<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function getTransactionHistory(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $game = $params['game'];
        $platform = $params['platform'];

        $hash = hash("SHA256", http_build_query($params));
        $params['hash']  = $hash;

        $response = Http::withHeaders($header)->get(env(strtoupper($game) . '_API_URL') . "/$platform/history/transaction", $params);

        return response()->json($response->json());
    }

    public function getOrderDetail(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $game = $params['game'];
        $platform = $params['platform'];

        $hash = hash("SHA256", http_build_query($params));
        $params['hash']  = $hash;

        $response = Http::withHeaders($header)->get(env(strtoupper($game) . '_API_URL') . "/$platform/history/detail/order", $params);

        return response()->json($response->json());
    }

    public function getDetailUrl(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $game = $params['game'];
        $platform = $params['platform'];

        $hash = hash("SHA256", http_build_query($params));
        $params['hash']  = $hash;

        $response = Http::withHeaders($header)->get(env(strtoupper($game) . '_API_URL') . "/$platform/history/detail/url", $params);

        return response()->json($response->json());
    }
}
