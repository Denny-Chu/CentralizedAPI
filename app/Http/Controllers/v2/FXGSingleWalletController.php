<?php

namespace App\Http\Controllers\v2;

use App\Http\Services\CommonService;
use App\Models\Cagent;
use App\Models\MemberInfo;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FXGSingleWalletController extends Controller
{
    public function __construct() {}

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
        $response = Http::withHeaders($header)->post(env(strtoupper($game) . '_V2_API_URL') . "/$platform/transfer?hash=$hash", $params);
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

    /**
     *
     */
    public function login(Request $request)
    {
        try {
            //$token = "670ce0820f109";//uniqid(mt_srand((double)microtime() * 1000000));//"670cd1cee8d52";//
            $token = $request->input('token');
            $params = [
                'Token' => $token,
                'GameID' => $request->input('GameID'),
                'AgentName' => env('FXG_SW_ANGENT'),
                /* 'lang' => $request->input('lang', 'en'),
                'homeURL' => $request->input('homeURL') */
            ];

            $memberInfo = MemberInfo::where('memId', $request->input('username'))->first();
            if (empty($memberInfo)) {
                $cagent = Cagent::where('api_key_sw', $request->header('authorization'))->first();
                MemberInfo::create([
                    'cagent_uid' => $cagent->uid,
                    'memId' => $request->input('username'),
                    'passwd' => $token,
                    'currency_code' => $cagent->currency
                ]);
            } else {
                $memberInfo->update(['passwd' => $token]);
            }

            $response = CommonService::swGetUrlResponse4FxG($request, $params, "login", "get");
            //var_dump($response);

            return response()->json($response->json());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(["ErrorCode" => 99]);
        }
    }

    /**
     *
     */
    public function logout(Request $request)
    {
        $params = $request->all();

        $response = CommonService::swGetUrlResponse4FxG($request, $params, "logout", "post");

        return response()->json($response->json());
    }

    public function games(Request $request)
    {
        try {
            $params = [
                'AgentName' => env('FXG_SW_ANGENT'),
            ];

            $response = CommonService::swGetUrlResponse4FxG($request, $params, "games", "get");
            //var_dump($response);

            return response()->json($response->json());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(["ErrorCode" => 99]);
        }
    }

    /**
     *
     */
    public function agents(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $response = CommonService::swGetUrlResponse4FxG($request, $params, "agents", "get");

        return response()->json($response->json());
    }

    /* public function auth(Request $request)
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
    } */
}
