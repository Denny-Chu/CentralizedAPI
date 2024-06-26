<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function transfer(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $game = $params['game'];
        $platform = $params['platform'];

        $hash = hash("SHA256", json_encode($params));

        $response = Http::withHeaders($header)->post(env(strtoupper($game) . '_API_URL') . "/$platform/transfer?hash=$hash", $params);

        return response()->json($response->json());
    }

    public function getTransferHistory(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $game = $params['game'];
        $platform = $params['platform'];

        $hash = hash("SHA256", http_build_query($params));
        $params['hash']  = $hash;

        $response = Http::withHeaders($header)->get(env(strtoupper($game) . '_API_URL') . "/$platform/history/transfer", $params);

        return response()->json($response->json());
    }
}
