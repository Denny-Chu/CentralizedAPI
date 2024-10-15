<?php

$router->group(['middleware' => ['whitelist', 'walletTypeCheck.sw']], function () use ($router) {
    $router->get('/agents', 'FXGSingleWalletController@agents');
    $router->group(['middleware' => ['sw.auth']], function () use ($router) {
            $router->get('/login', 'FXGSingleWalletController@login');
            $router->post('/logout', 'FXGSingleWalletController@logout');
    });
    $router->get('/games', 'FXGSingleWalletController@games');
});

//https://developers.91url.cc/fxg/sw/api/callback/auth
// 單一錢包回調部分
$router->group(['prefix' => 'callback', 'middleware' => ['sw.request']], function () use ($router) {
        $router->post('/auth', ['as' => 'auth', 'uses' => 'FXGSwController@auth']);
        $router->group(['middleware' => ['sw.FXGgameAuth']], function () use ($router) {
            $router->post('/balance', ['as' => 'balance', 'uses' => 'FXGSwController@balance']);
            $router->post('/bet', ['as' => 'bet', 'uses' => 'FXGSwController@bet']);
            $router->post('/cancelBet', ['as' => 'cancelBet', 'uses' => 'FXGSwController@cancelBet']);
        });
});
