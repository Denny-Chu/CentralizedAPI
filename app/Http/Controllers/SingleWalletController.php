<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class singleWalletController extends Controller
{
    protected function __construct() {}

    /**
     * 查詢訂單(限定時間區間五分鐘、並要指定玩家)
     * @return json 將回應查詢到的注單中所有請求
     */
    public function checkOrder(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');
        $game = $params['game'];

        $platform = $params['platform'];
        $hash = hash("SHA256", json_encode($params));
        $response = Http::withHeaders($header)->post(env(strtoupper($game) . '_SINGLEWALLET_API_URL') . "/$platform/transfer?hash=$hash", $params);
    }

    /**
     * 
     */
    public function resendTransaction(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $orderId = $validatedData['order_id'];
    }

    public function auth(Request $request)
    {
        //
    }
    public function balance(Request $request)
    {
        //
    }
    public function bet(Request $request)
    {
        //
    }
    public function cancelBet(Request $request)
    {
        //
    }
    public function logout(Request $request)
    {
        //
    }
    
}
