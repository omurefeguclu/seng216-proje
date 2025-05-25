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
        'TotalCount' => $pager->count(),
        'Items' => $data
    ]);
}

function dropdown_json(\Propel\Runtime\Collection\Collection|array $items, callable $valueSelector, callable $textSelector) {
    $result = [];

    foreach ($items as $item) {
        $result[$textSelector($item)] = $valueSelector($item);
    }

    return ok_json($result);
}

function error_json($error = []){
    prepare_json_result();

    return json_encode(['errors' => $error]);
}


function cycle_paths(array $viewPaths, string $viewName): string|null {
    foreach ($viewPaths as $viewPath) {
        $viewFile = $viewPath . $viewName . '.php';
        if (file_exists($viewFile)) {
            return $viewFile;
        }
    }

    return null;
}
function view(string $viewName, array $data = [], string $layoutViewName='layout'): string {
    // Guess the caller's file path (the .php that called `view()`)
    $callerFile = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[0]['file'] ?? null;

    if ($callerFile) {
        $moduleDir = dirname($callerFile); // e.g., modules/vehicles
        $moduleViewPath = $moduleDir . '/views/';
    } else {
        http_response_code(500);
        return "Unable to resolve view path.";
    }

    $searchViewPaths = [
        $moduleViewPath,
        __DIR__ . '/../../modules/shared/views/'
    ];

    $viewFile = cycle_paths($searchViewPaths, $viewName);
    if (!$viewFile) {
        http_response_code(500);
        return "View not found: $viewFile";
    }

    $layoutFile = cycle_paths($searchViewPaths, $layoutViewName);

    $viewEngine = new ViewEngine();
    extract($data);
    ob_start();
    require $viewFile;
    $content = ob_get_clean();

    // Layout is optional
    if (file_exists($layoutFile)) {
        ob_start();
        require $layoutFile;
        return ob_get_clean();
    }

    return $content;
}

function redirect($redirectLink = '/', $permanent = false): void
{
    header('Location: ' . $redirectLink, true, $permanent ? 301 : 302);

    // Based on documentation: https://thedailywtf.com/articles/WellIntentioned-Destruction
    die();
}