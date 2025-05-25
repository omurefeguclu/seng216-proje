<?php
function challenge(\Core\Http\RequestContext $ctx, string $message): false {
    http_response_code(403);
    $isJson = isset($ctx->headers['Content-Type']) &&
    stripos($ctx->headers['Content-Type'], 'application/json');

    if($isJson) {
        echo error_json($message);
    }
    else {
        echo $message;
        redirect('/auth/login');
    }


    return false;
}
function authMiddleware(): callable
{
    return function (\Core\Http\RequestContext $ctx): bool {
        $userId = $_SESSION['userId'] ?? null;
        if (!$userId) {
            return challenge($ctx, "Access denied");
        }

        $user = DbModel\UserQuery::create()->findPk($userId);
        if(!$user) {
            return challenge($ctx, "User not found");
        }



        $ctx->user = $user;
        return true;
    };
}