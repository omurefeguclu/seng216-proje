<?php

global $router;

use Core\Http\RequestContext;
use Propel\Runtime\ActiveQuery\Criteria;

$router->group('/api/warehouses')
    ->get('/form/{id}', function ($id) {
        $entity = DbModel\WarehouseQuery::create()->findPk($id);
        if(!$entity){
            return error_json('Vehicle not found with id ' . $id);
        }

        return ok_json($entity->toArray());
    })
    ->post('/list', function (RequestContext $ctx) {
        $searchDto = $ctx->json();

        $query = DbModel\WarehouseQuery::create();
        if(isset($searchDto['Name'])){
            $query = $query->filterByName('%' . $searchDto['Name'] . '%', Criteria::LIKE);
        }
        $pageIndex = $searchDto['PageIndex'] ?? 0;
        $pageSize = $searchDto['PageSize'] ?? 10;
        $result_list = $query
            ->orderByCreatedOn(Criteria::DESC)
            ->paginate($pageIndex + 1, $pageSize);

        return paginated_json($result_list);
    })
    ->post('/form', function(RequestContext $ctx) {
        $insertDto = $ctx->json();

        $entity = new DbModel\Warehouse();
        $entity = $entity->fromArray($insertDto);

        $entity->save();

        return ok_json($entity->toArray());
    })
    ->post('/form/{id}', function($id, RequestContext $ctx) {
        $entity = DbModel\WarehouseQuery::create()->findPk($id);
        if(!$entity){
            return error_json('Vehicle not found with id ' . $id);
        }

        $insertDto = $ctx->json();

        $entity = $entity->fromArray($insertDto);
        $entity->save();

        return ok_json($entity->toArray());
    })
    ->get('/delete/{id}', function ($id) {

        $entity = DbModel\WarehouseQuery::create()->findPk($id);
        if(!$entity){
            return error_json('Vehicle not found with id ' . $id);
        }

        $entity->delete();

        return ok_json();
    })
    ->post('/stock-transactions/{id}', function ($id, RequestContext $ctx) {
        $searchDto = $ctx->json();

        $pageIndex = $searchDto['PageIndex'] ?? 0;
        $pageSize = $searchDto['PageSize'] ?? 10;
        $results = \DbModel\WarehouseProductStockLogQuery::create()
            ->filterByWarehouseId($id)
            ->orderByCreatedOn(Criteria::DESC)
            ->paginate($pageIndex + 1, $pageSize);

        return paginated_json($results);
    })
    ->post('/create-stock-log', function (RequestContext $ctx) {
        $insertDto = $ctx->json();

        $entity = new DbModel\WarehouseProductStockLog();
        $entity = $entity->fromArray($insertDto);

        $entity->save();

        return ok_json($entity->toArray());
    })
    ->post('/stocks/{id}', function($id, RequestContext $ctx) {
        $searchDto = $ctx->json();

        $pageIndex = $searchDto['PageIndex'] ?? 0;
        $pageSize = $searchDto['PageSize'] ?? 10;
        $results = \DbModel\WarehouseProductStockLogQuery::create()
            ->filterByWarehouseId($id)
            ->select(['ProductId'])
            ->withColumn("
        SUM(
            CASE 
                WHEN is_received THEN amount 
                ELSE -amount
            END
        )
    ", 'TotalStock')
            ->groupByProductId()
            ->orderBy('ProductId')
            ->paginate($pageIndex + 1, $pageSize);

        $data = array_map(fn($item) => $item, iterator_to_array($results));


        return ok_json([
            'TotalCount' => $results->getNbResults(),
            'Items' => $data
        ]);
    })
    ->get('/get-dropdown', function (){
        $entities = DbModel\WarehouseQuery::create()
            ->orderByCreatedOn(Criteria::DESC)
            ->find();

        return dropdown_json($entities, fn($entity)=>$entity->getId(), fn($entity)=>$entity->getName());
    })
    ->middleware([authMiddleware()]);

$router->group('/warehouses')
    ->get('/', function(){
        return view('list');
    })
    ->middleware([authMiddleware()]);