<?php
require_once __DIR__ . '/../views/view_engine.php';

function prepare_json_result(){
    header('Content-type: application/json');
}

function ok_json($object = []){
    prepare_json_result();

    return json_encode($object);
}

function paginated_json(\Propel\Runtime\Util\PropelModelPager|array $pager = []) {
    $data = array_map(fn($item) => $item->toArray(), iterator_to_array($pager));


    return ok_json([
        'TotalCount' => $pager->getNbResults(),
        'Items' => $data
    ]);
}

function dropdown_json(\Propel\Runtime\Collection\Collection|array $items, callable $valueSelector, callable $textSelector) {
    $result = [];

    foreach ($items as $item) {
        $result[$valueSelector($item)] = $textSelector($item);
    }

    return ok_json($result);
}

function error_json($error = []){
    prepare_json_result();

    return json_encode(['Errors' => $error]);
}


function view(string $viewName, array $data = []): string {
    try {
        global $requestContext;

        // Guess the caller's file path (the .php that called `view()`)
        $callerFile = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[0]['file'] ?? null;

        if ($callerFile) {
            $moduleDir = dirname($callerFile); // e.g., modules/vehicles
            $moduleViewPath = $moduleDir . '/views/';
        } else {
            http_response_code(500);
            return "Unable to resolve view path.";
        }

        $viewEngine = new ViewEngine($moduleViewPath, $requestContext);
        $GLOBALS['viewEngine'] = $viewEngine;

        return $viewEngine->renderView($viewName, $data);
    }
    catch (Exception $e) {
        http_response_code(500);

        return $e->getMessage();
    }
}

function redirect($redirectLink = '/', $permanent = false): void
{
    header('Location: ' . $redirectLink, true, $permanent ? 301 : 302);

    // Based on documentation: https://thedailywtf.com/articles/WellIntentioned-Destruction
    die();
}