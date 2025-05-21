<?php
function authMiddleware(): callable
{
    return function (\Core\Http\RequestContext $ctx): bool {
        $userId = $_SESSION['userId'] ?? null;
        if (!$userId) {
            http_response_code(403);
            echo "Access denied";

            return false;
        }

        $user = DbModel\UserQuery::create()->findPk($userId);
        if(!$user) {
            http_response_code(403);
            echo "User not found";

            return false;
        }



        $ctx->user = $user;
        return true;
    };
}