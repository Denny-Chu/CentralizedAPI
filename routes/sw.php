<?php


$router->group(['middleware' => ['whitelist']], function () use ($router) {
    $router->get('/checkOrder', 'SingleWalletController@checkOrder');
    $router->get('/resendTransaction', 'SingleWalletController@resendTransaction');
});

// 單一錢包回調部分
$router->group(['prefix' => 'callBack'], function () use ($router) {
    $router->group(['prefix' => 'bingo', 'namespace' => 'Bingo'], function () use ($router) {
        $router->post('/auth', 'SwController@auth');
        $router->group(['middleware' => ['sw.auth']], function () use ($router) {
            $router->post('/balance', 'SwController@balance');
            $router->post('/bet', 'SwController@bet');
            $router->post('/cancelBet', 'SwController@cancelBet');
        });
    });
});
