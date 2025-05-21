<?php

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

function error_json($error = []){
    prepare_json_result();

    return json_encode(['errors' => $error]);
}
