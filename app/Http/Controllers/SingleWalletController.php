<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class singleWalletController extends Controller
{
    protected function __construct()
    {
    }

    /**
     * 查詢訂單(限定時間區間五分鐘、並要指定玩家)
     * @return json 將回應查詢到的注單中所有請求
     */
    public function queryOrder(Request $request)
    {
    }

    /**
     * 
     */
    public function resendOrder(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);
    
        $orderId = $validatedData['order_id'];
    }
}
