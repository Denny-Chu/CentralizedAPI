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

$router->group(['prefix' => 'transaction'], function () use ($router) {
    $router->post('/transfer', 'TransactionController@transfer');
    $router->get('/history', 'TransactionController@getTransferHistory');
});

$router->group(['prefix' => 'game'], function () use ($router) {
    $router->get('/history', 'TransactionController@getTransactionHistory');
    $router->get('/detail', 'GameController@getDetail');
    $router->get('/detailUrl', 'GameController@getDetailUrl');
});
