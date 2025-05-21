<?php

function validate_not_null(array $params): bool
{
    if (empty($params)) { return true; }

    foreach ($params as $paramName => $paramValue) {
        // Consider for booleans
        if(!$paramValue){
            echo $paramName . ' Should not be null';
            http_response_code(400);

            return false;
        }
    }

    return true;
}