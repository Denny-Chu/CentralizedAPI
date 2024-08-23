<?php

namespace App\Http\v2\Bingo\Controllers;

use App\Http\v2\Controllers\SingleWalletController;
use App\Http\Services\CommonService;
use App\Http\Services\SingleWalletService;
use App\Models\MemberInfo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SwController extends SingleWalletController
{
    protected $singleWalletService;

    public function __construct(SingleWalletService $singleWalletService)
    {
        $this->singleWalletService = $singleWalletService;
        $this->singleWalletService->platform = 'bingo';
    }

    public function auth(Request $request)
    {
        try {
            $functionName = __FUNCTION__;
            return DB::transaction(function () use ($request, $functionName) {
                $user = MemberInfo::where('passwd', $request->json('token'))->first();
                $parseResult = CommonService::parseUsername($user->memId);
                $request->merge([
                    'cagent' => $parseResult['cagent'],
                    'agent' => $parseResult['agent'],
                    'username' => $parseResult['username'],
                    'cagent_model' => $parseResult['cagent_model'],
                ]);
                $this->singleWalletService->handleRequest($request, $functionName);
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(["ErrorCode" => 99]);
        }
    }

    public function balance(Request $request)
    {
        try {
            $functionName = __FUNCTION__;
            return DB::transaction(function () use ($request, $functionName) {
                return $this->singleWalletService->handleRequest($request, $functionName);
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(["ErrorCode" => 99]);
        }
    }

    public function bet(Request $request)
    {
        try {
            $functionName = __FUNCTION__;
            return DB::transaction(function () use ($request, $functionName) {
                return $this->singleWalletService->handleRequest($request, $functionName);
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(["ErrorCode" => 99]);
        }
    }

    public function cancelBet(Request $request)
    {
        try {
            $functionName = __FUNCTION__;
            return DB::transaction(function () use ($request, $functionName) {
                return $this->singleWalletService->handleRequest($request, $functionName);
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(["ErrorCode" => 99]);
        }
    }
}
