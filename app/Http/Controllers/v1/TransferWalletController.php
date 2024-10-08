<?php

namespace App\Http\Controllers\v1;

use App\Http\Services\CommonService;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TransferWalletController extends Controller
{
    public function getMoney(Request $request)
    {
        //
    }
    public function transfer(Request $request)
    {
        //
    }
    public function getTransferHistory(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $response = CommonService::getUrlResponse($header, $params, "history/transfer", "get");

        return response()->json($response->json());
    }
}
