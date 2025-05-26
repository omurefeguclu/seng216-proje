<?php

global $router;

use Core\Http\RequestContext;
use Propel\Runtime\ActiveQuery\Criteria;

$router->group('/api/stock-transactions')
    ->get('/form/{id}', function ($id) {
        $entity = DbModel\StockTransactionQuery::create()->findPk($id);
        if(!$entity){
            return error_json('Vehicle not found with id ' . $id);
        }

        return ok_json($entity->toArray());
    })
    ->post('/list', function (RequestContext $ctx) {
        $searchDto = $ctx->json();

        $query = DbModel\StockTransactionQuery::create();
        if(isset($searchDto['WarehouseId'])){
            $query = $query->filterByFromWarehouseId($searchDto['WarehouseId'])
            ->_or()
            ->filterByToWarehouseId($searchDto['WarehouseId']);
        }
        if(isset($searchDto['VehicleId'])){
            $query = $query
                ->_and()
                ->filterByVehicleId($searchDto['VehicleId']);
        }
        $pageIndex = $searchDto['PageIndex'] ?? 0;
        $pageSize = $searchDto['PageSize'] ?? 10;
        $result_list = $query->paginate($pageIndex + 1, $pageSize);

        return paginated_json($result_list);
    })
    ->post('/form', function(RequestContext $ctx) {
        $insertDto = $ctx->json();

        $entity = new DbModel\StockTransaction();
        $entity = $entity->fromArray($insertDto);

        $entity->save();

        return ok_json($entity->toArray());
    })
    ->post('/form/{id}', function($id, RequestContext $ctx) {
        $entity = DbModel\StockTransactionQuery::create()->findPk($id);
        if(!$entity){
            return error_json('Vehicle not found with id ' . $id);
        }

        $insertDto = $ctx->json();

        $entity = $entity->fromArray($insertDto);
        $entity->save();

        return ok_json($entity->toArray());
    })
    ->get('/delete/{id}', function ($id) {

        $entity = DbModel\StockTransactionQuery::create()->findPk($id);
        if(!$entity){
            return error_json('Vehicle not found with id ' . $id);
        }

        $entity->delete();

        return ok_json();
    })
    ->middleware([authMiddleware()]);

$router->group('/stock-transactions')
    ->get('/', function(){
        return view('list');
    })
    ->middleware([authMiddleware()]);