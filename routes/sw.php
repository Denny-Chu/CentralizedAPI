<?php


$router->group(['middleware' => ['whitelist', 'walletTypeCheck.sw']], function () use ($router) {
    $router->get('/agents', 'SingleWalletController@agents');
    $router->group(['middleware' => ['sw.auth']], function () use ($router) {
            $router->get('/login', 'SingleWalletController@login');
            $router->post('/logout', 'SingleWalletController@logout');
    });
});

// 單一錢包回調部分
$router->group(['prefix' => 'callback', 'middleware' => ['sw.request']], function () use ($router) {
    $router->group(['prefix' => 'bingo', 'namespace' => 'Bingo'], function () use ($router) {
        $router->post('/auth', ['as' => 'auth', 'uses' => 'SwController@auth']);
        $router->group(['middleware' => ['sw.gameAuth']], function () use ($router) {
            $router->post('/balance', ['as' => 'balance', 'uses' => 'SwController@balance']);
            $router->post('/bet', ['as' => 'bet', 'uses' => 'SwController@bet']);
            $router->post('/cancelBet', ['as' => 'cancelBet', 'uses' => 'SwController@cancelBet']);
        });
    });
});
