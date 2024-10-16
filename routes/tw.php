<?php

$router->group(['middleware' => ['whitelist', 'walletTypeCheck.tw']], function () use ($router) {
    // 目前只有bingo有jackpot跟event的額外設置
    $router->group(['prefix' => 'jackpot', 'namespace' => 'Bingo'], function () use ($router) {
        $router->get('/getGameJackpot', 'Controllers\JackpotController@getGameJackpot');
        $router->get('/getJackpotPlayers', 'JackpotController@getJackpotPlayers');
    });

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
        $router->post('/transfer', 'PlayerController@transfer');
        $router->post('/getMoney', 'PlayerController@getMoney');
    });

    $router->group(['prefix' => 'game'], function () use ($router) {
        $router->get('/history', 'GameController@getTransactionHistory');
        $router->get('/detail', 'GameController@getOrderDetail');
        $router->get('/detailUrl', 'GameController@getDetailUrl');
    });

    $router->group(['prefix' => 'transaction'], function () use ($router) {
        $router->get('/history', 'GameController@getTransferHistory');
    });

    $router->group(['prefix' => 'event'], function () use ($router) {
        $router->post('/registerEvent', 'EventController@registerEvent');
    });
});
