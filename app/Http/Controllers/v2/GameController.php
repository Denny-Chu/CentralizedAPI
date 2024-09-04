<?php

namespace App\Http\Controllers\v2;

use Illuminate\Http\Request;
use App\Http\Services\CommonService;

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
        // $params = $request->all();
        // $header['authorization'] = $request->header('authorization');
        // $response = CommonService::getUrlResponse($header, $params, "history/transaction", "get", true);

        // return response()->json($response->json());
    }

    public function getOrderDetail(Request $request)
    {
        // $params = $request->all();
        // $header['authorization'] = $request->header('authorization');
        // $response = CommonService::getUrlResponse($header, $params, "history/detail/order", "get", true);


        // return response()->json($response->json());
    }

    public function getDetailUrl(Request $request)
    {
        // $params = $request->all();
        // $header['authorization'] = $request->header('authorization');
        // $response = CommonService::getUrlResponse($header, $params, "history/detail/url", "get", true);

        // return response()->json($response->json());
    }
}
