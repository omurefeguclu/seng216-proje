<?php

global $router;

$router->group('/dashboard')
->get('/', function (\Core\Http\RequestContext $ctx){

    return $ctx->user->getId() . ' Test test test';
})
->middleware([authMiddleware()]);

