<?php

global $router;

require_once '../modules/auth/middleware.php';
use UsersQuery;

$router->group('/auth')
->get('/login', function (RequestContext $ctx){

    $loginQuery = new UsersQuery();
    $foundUser = $loginQuery->findOneByUsername('TestTest');
    if(!$foundUser) {
        return "User not found";
    }

    // Set session userId
    $_SESSION["userId"] = $foundUser->getId();

    return "Successfully logged in";
});
