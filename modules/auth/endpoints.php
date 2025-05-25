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
        return error_json("User not found");
    }

    if($foundUser->getPassword() !== $data['Password']) {
        return error_json("Wrong password");
    }

    // Set session userId
    $_SESSION["userId"] = $foundUser->getId();

    $result = new AuthResultDto($foundUser->getId());

    return ok_json($result);
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
        return error_json("Username already exists");
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
    })
    ->get('/logout', function (\Core\Http\RequestContext $ctx) {
        session_destroy();

        return redirect('/auth/login');
    });;
