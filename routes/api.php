<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

// $router->group(['prefix' => 'transaction'], function () use ($router) {
//     $router->post('/transfer', 'TransactionController@transfer');
//     $router->get('/history', 'TransactionController@getTransferHistory');
// });

$router->group(['prefix' => 'game'], function () use ($router) {
    $router->get('/history', 'GameController@getTransactionHistory');
    $router->get('/detail', 'GameController@getOrderDetail');
    $router->get('/detailUrl', 'GameController@getDetailUrl');

    $router->group(['namespace' => 'bingo'], function () use ($router) {
        $router->group(['prefix' => 'jackpot'], function () use ($router) {
            $router->get('/getGameJackpot', 'jackpotController@getGameJackpot');
            $router->get('/getJackpotPlayers', 'jackpotController@getJackpotPlayers');
        });

        $router->group(['prefix' => 'event'], function () use ($router) {
            $router->post('/registerEvent', 'eventController@registerEvent');
            $router->get('/getJackpotPlayers', 'eventController@getJackpotPlayers');
        });
    });
});

$router->group(['prefix' => 'sw'], function () use ($router) {
    $router->get('/checkOrder', 'singleWalletController@checkOrder');
    $router->get('/resendTransaction', 'singleWalletController@resendTransaction');
});

$router->group(['prefix' => 'tw'], function () use ($router) {
    $router->post('/getMoney', 'transferWalletController@getMoney');
    $router->post('/transfer', 'transferWalletController@transfer');
    $router->get('/history', 'transferWalletController@getTransferHistory');
});
