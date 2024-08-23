<?php

namespace App\Http\Controllers\Bingo;

use App\Http\Controllers\singleWalletController;
use App\Services\SingleWalletService;
use Illuminate\Http\Request;

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
        return $this->singleWalletService->handleRequest($request, __FUNCTION__);
    }

    public function balance(Request $request)
    {
        return $this->singleWalletService->handleRequest($request, __FUNCTION__);
    }

    public function bet(Request $request)
    {
        return $this->singleWalletService->handleRequest($request, __FUNCTION__);
    }

    public function cancelBet(Request $request)
    {
        return $this->singleWalletService->handleRequest($request, __FUNCTION__);
    }
}