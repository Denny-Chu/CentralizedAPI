<?php

require_once __DIR__ . '/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();

$app->withEloquent();

class_alias(Illuminate\Support\Facades\Http::class, 'Http');

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
| Now we will register the "app" configuration file. If the file exists in
| your configuration directory it will be loaded; otherwise, we'll load
| the default version. You may register other files below as needed.
|
*/

$app->configure('app');

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

$app->routeMiddleware([
    'sw.gameAuth' => App\Http\Middleware\SwGameMiddleware::class,
    'sw.FXGgameAuth' => App\Http\Middleware\FXGSwGameMiddleware::class,
    'sw.auth' => App\Http\Middleware\SwAuthenticateMiddleware::class,
    'sw.request' => App\Http\Middleware\SwRequestMiddleware::class,
    'whitelist' => App\Http\Middleware\WhitelistMiddleware::class,
    'walletTypeCheck.tw' => App\Http\Middleware\IsTwWalletMiddleware::class,
    'walletTypeCheck.sw' => App\Http\Middleware\IsSwWalletMiddleware::class,
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);
$app->register(App\Providers\LogServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__ . '/../routes/web.php';
});

$app->router->group([
    'namespace' => 'App\Http\Controllers\v1',
    'prefix' => 'api',
], function ($router) {
    require __DIR__ . '/../routes/tw.php';
});

$app->router->group([
    'namespace' => 'App\Http\Controllers\v2',
    'prefix' => 'sw/api',
], function ($router) {
    require __DIR__ . '/../routes/sw.php';
});

//https://developers.91url.cc/fxg/sw/api
$app->router->group([
    'namespace' => 'App\Http\Controllers\v2',
    'prefix' => 'fxg/sw/api',
], function ($router) {
    require __DIR__ . '/../routes/fxgsw.php';
});

return $app;
