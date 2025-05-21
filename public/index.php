<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../generated-conf/config.php';

$router = new Router();

foreach (glob(__DIR__ . '/../modules/*/endpoints.php') as $file) {
    require $file;
}

$router->dispatch();