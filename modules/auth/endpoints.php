<?php

global $router;

require_once __DIR__ . '/models/AuthResultDto.php';

$router->group('/api/auth')
->post('/login', function (\Core\Http\RequestContext $ctx) {
    $data = $ctx->json();

    if(!validate_not_null([
        'Username' => $data['Username'],
        'Password' => $data['Password']
    ])) { return; }

    $loginQuery = new DbModel\UserQuery();
    $foundUser = $loginQuery->findOneByUsername($data['Username']);

    if(!$foundUser) {
        return "User not found";
    }

    if($foundUser->getPassword() !== $data['Password']) {
        return "Wrong password";
    }

    // Set session userId
    $_SESSION["userId"] = $foundUser->getId();

    $result = new AuthResultDto($foundUser->getId());

    header("Content-Type: application/json");
    return json_encode($result);
})
->post('/register', function (\Core\Http\RequestContext $ctx) {
    $data = $ctx->json();

    if(!validate_not_null([
        'Username' => $data['Username'],
        'Password' => $data['Password']
    ])) { return; }

    $existingUserQuery = new DbModel\UserQuery();
    $user = $existingUserQuery->findOneByUsername($data['Username']);
    if($user) {
        return "Username already exists";
    }

    $user = new DbModel\User();
    $user->setUsername($data['Username']);
    $user->setPassword($data['Password']);
    $user->save();

    // Set session userId
    $_SESSION["userId"] = $user->getId();

    $result = new AuthResultDto($user->getId());

    return ok_json($result);
});

$router->group('/auth')
    ->get('/login', function (){
       return view('login', [], '_root');
    });
