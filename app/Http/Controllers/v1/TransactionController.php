<?php

namespace App\Http\v1\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CommonService;
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

        if ($game === "LOTTO") {
            $response = CommonService::getUrlResponse($header, $params, "transfer", "post");
        } else {
            $platform = $params['platform'];
            $hash = hash("SHA256", json_encode($params));
            $response = Http::withHeaders($header)->post(env(strtoupper($game) . '_API_URL') . "/$platform/transfer?hash=$hash", $params);
        }

        return response()->json($response->json());
    }
}
