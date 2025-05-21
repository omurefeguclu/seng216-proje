<?php

global $router;

require_once '../modules/auth/middleware.php';

$router->group('/dashboard')
->get('/', function (RequestContext $ctx){

    return $ctx->user . ' Test test test';
})
->middleware([authMiddleware()]);

