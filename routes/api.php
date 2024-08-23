<?php

use App\Http\Bingo\Controllers\EventController;
use App\Http\Bingo\Controllers\JackpotController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Bingo\SwController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\singleWalletController;
use App\Http\Controllers\TransferWalletController;
use Illuminate\Support\Facades\Route;


// 屬於商戶發送請求的區域，需驗證header以及IP白名單
Route::group(['middleware' => ['whitelist']], function () {
    // 不分類區
    Route::group(['prefix' => 'auth'], function () {
        Route::get('/demoLogin', [AuthController::class, 'demoLogin']);
        Route::get('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logoutAll', [AuthController::class, 'logoutAll']);
    });

    Route::group(['prefix' => 'agent'], function () {
        Route::post('/', [AgentController::class, 'createAgent']);
        Route::get('/', [AgentController::class, 'getAgent']);
    });

    Route::group(['prefix' => 'player'], function () {
        Route::post('/create', [PlayerController::class, 'createPlayer']);
        Route::get('/status', [PlayerController::class, 'playerStatus']);
        Route::get('/online', [PlayerController::class, 'onlinePlayersList']);
    });

    Route::group(['prefix' => 'game'], function () {
        Route::get('/history', [GameController::class, 'getTransactionHistory']);
        Route::get('/detail', [GameController::class, 'getOrderDetail']);
        Route::get('/detailUrl', [GameController::class, 'getDetailUrl']);
    });

    // 目前只有bingo有jackpot跟event的額外設置
    Route::group(['prefix' => 'jackpot'], function () {
        // 未完成
        Route::get('/getGameJackpot', [JackpotController::class, 'getGameJackpot']);
        // 未完成
        Route::get('/getJackpotPlayers', [JackpotController::class, 'getJackpotPlayers']);
    });

    Route::group(['prefix' => 'event'], function () {
        // 未完成
        Route::post('/registerEvent', [EventController::class, 'registerEvent']);
    });

    // 單一錢包專屬
    Route::group(['prefix' => 'sw'], function () {
        // 未完成
        Route::get('/checkOrder', [singleWalletController::class, 'checkOrder']);
        // 未完成
        Route::get('/resendTransaction', [SingleWalletController::class, 'resendTransaction']);
    });

    // 轉帳錢包專屬
    Route::group(['prefix' => 'tw'], function () {
        // 未完成
        Route::post('/getMoney', [TransferWalletController::class, 'getMoney']);
        // 未完成
        Route::post('/transfer', [TransferWalletController::class, 'transfer']);
        Route::get('/history', [TransferWalletController::class, 'getTransferHistory']);
    });
});

// 單一錢包回調部分
Route::group(['middleware' => ['sw.user.auth'], 'prefix' => 'swCallBack'], function () {
    Route::group(['prefix' => 'bingo'], function () {
        // 未測試
        Route::post('/auth', [SwController::class, 'auth']);
        // 未測試
        Route::post('/balance', [SwController::class, 'balance']);
        // 未測試
        Route::post('/bet', [SwController::class, 'bet']);
        // 未測試
        Route::post('/cancelBet', [SwController::class, 'cancelBet']);
    });
});