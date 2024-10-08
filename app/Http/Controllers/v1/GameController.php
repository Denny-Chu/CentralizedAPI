<?php

namespace App\Http\Controllers\v1;

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

    // 下注紀錄
    public function getTransactionHistory(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $response = CommonService::getUrlResponse($header, $params, "history/transaction", "get");

        return response()->json($response->json());
    }

    public function getOrderDetail(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $response = CommonService::getUrlResponse($header, $params, "history/detail/order", "get");


        return response()->json($response->json());
    }

    public function getDetailUrl(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $response = CommonService::getUrlResponse($header, $params, "history/detail/url", "get");

        return response()->json($response->json());
    }

    // 轉帳紀錄
    public function getTransferHistory(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $response = CommonService::getUrlResponse($header, $params, "history/transfer", "get");

        return response()->json($response->json());
    }
}
