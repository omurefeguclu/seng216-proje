<?php

function authMiddleware(): callable
{
    return function (RequestContext $ctx): bool {
        $userId = $_SESSION['userId'] ?? null;
        if (!$userId) {
            http_response_code(403);
            echo "Access denied";
            return false;
        }

        $ctx->user = $userId;
        return true;
    };
}