<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\v2\FXGSingleWalletController;
use App\Http\Services\CommonService;
use App\Http\Services\FXGSingleWalletService;
use App\Models\MemberInfo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FXGSwController extends FXGSingleWalletController
{
    protected $fxgsingleWalletService;

    public function __construct(FXGSingleWalletService $fxgsingleWalletService)
    {
        $this->fxgsingleWalletService = $fxgsingleWalletService;
        $this->fxgsingleWalletService->platform = 'FxG';
    }

    public function auth(Request $request)
    {
        try {
            $functionName = __FUNCTION__;
            return DB::transaction(function () use ($request, $functionName) {
                $user = MemberInfo::where('passwd', $request->input('Token'))->first();

                $parseResult = CommonService::parseUsername($user->memId);
                $request->merge([
                    'parseData' => [
                        'cagent' => $parseResult['cagent'],
                        'agent' => $parseResult['agent'],
                        'cagent_model' => $parseResult['cagent_model'],
                    ]
                ]);
                return $this->fxgsingleWalletService->handleRequest($request, $functionName, $user->memId);
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
                return $this->fxgsingleWalletService->handleRequest($request, $functionName, $request->Username);
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
                return $this->fxgsingleWalletService->handleRequest($request, $functionName, $request->Username);
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
                return $this->fxgsingleWalletService->handleRequest($request, $functionName, $request->Username);
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(["ErrorCode" => 99]);
        }
    }
}
