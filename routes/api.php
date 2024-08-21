<?php

/** @var \Laravel\Lumen\Routing\Router $router */

// 不分類區

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->get('/demoLogin', 'AuthController@demoLogin');
    $router->get('/login', 'AuthController@login');
    $router->post('/logout', 'AuthController@logout');
    $router->post('/logoutAll', 'AuthController@logoutAll');
});

$router->group(['prefix' => 'agent'], function () use ($router) {
    $router->post('/', 'AgentController@createAgent');
    $router->get('/', 'AgentController@getAgent');
});

$router->group(['prefix' => 'player'], function () use ($router) {
    $router->post('/create', 'PlayerController@createPlayer');
    $router->get('/status', 'PlayerController@playerStatus');
    $router->get('/online', 'PlayerController@onlinePlayersList');
});

$router->group(['prefix' => 'game'], function () use ($router) {
    $router->get('/history', 'GameController@getTransactionHistory');
    $router->get('/detail', 'GameController@getOrderDetail');
    $router->get('/detailUrl', 'GameController@getDetailUrl');
});

// 目前只有bingo有jackpot跟event的額外設置
$router->group(['namespace' => 'Bingo'], function () use ($router) {
    $router->group(['prefix' => 'jackpot'], function () use ($router) {
        $router->get('/getGameJackpot', 'jackpotController@getGameJackpot');
        $router->get('/getJackpotPlayers', 'jackpotController@getJackpotPlayers');
    });

    $router->group(['prefix' => 'event'], function () use ($router) {
        $router->post('/registerEvent', 'eventController@registerEvent');
    });
});

// 單一錢包專屬
$router->group(['prefix' => 'sw'], function () use ($router) {
    $router->get('/checkOrder', 'singleWalletController@checkOrder');
    $router->get('/resendTransaction', 'singleWalletController@resendTransaction');
});

// 轉帳錢包專屬
$router->group(['prefix' => 'tw'], function () use ($router) {
    $router->post('/getMoney', 'transferWalletController@getMoney');
    $router->post('/transfer', 'transferWalletController@transfer');
    $router->get('/history', 'transferWalletController@getTransferHistory');
});
