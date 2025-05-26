<?php

use Core\Http\RequestContext;

session_start();

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../generated-conf/config.php';
require_once __DIR__ . '/../features/features_index.php';

$requestContext = new RequestContext();
$router = new Core\Router\Router();

$router->routes()
    ->get('/', function() {
       return redirect('/dashboard', true);
    });

foreach (glob(__DIR__ . '/../modules/*/endpoints.php') as $file) {
    require $file;
}

$router->dispatch($requestContext);