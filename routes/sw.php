<?php


$router->group(['middleware' => ['whitelist']], function () use ($router) {
    // $router->get('/checkOrder', 'SingleWalletController@checkOrder');
    // $router->get('/resendTransaction', 'SingleWalletController@resendTransaction');
    $router->group(['middleware' => ['sw.auth']], function () use ($router) {
        $router->group(['prefix' => 'auth'], function () use ($router) {
            // $router->get('/demoLogin', 'AuthController@demoLogin');
            $router->get('/login', 'AuthController@login');
            // $router->post('/logout', 'AuthController@logout');
            // $router->post('/logoutAll', 'AuthController@logoutAll');
            // $router->post('/getMoney', 'AuthController@getMoney');
        });
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
