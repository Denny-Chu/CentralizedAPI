<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CommonService;

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
        $hash = hash("SHA256", json_encode($params));
        $response = CommonService::getUrlResponse($header, $params, "transfer", "post");

        return response()->json($response->json());
    }

    public function getTransferHistory(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $response = CommonService::getUrlResponse($header, $params, "history/transfer", "get");

        return response()->json($response->json());
    }
}
