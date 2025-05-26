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

        $fromProductStock = DbModel\WarehouseProductStockLogQuery::create()
            ->filterByWarehouseId($insertDto['FromWarehouseId'])
            ->filterByProductId($insertDto['ProductId'])
            ->withColumn("
        SUM(
            CASE 
                WHEN is_received THEN amount 
                ELSE -amount
            END
        )
    ", 'TotalStock')->findOne();

        // Propel nuance, virtual column is still present even if no result exist
        $totalStockColumn = $fromProductStock->getVirtualColumn('TotalStock');
        $totalStock = $totalStockColumn !== null ? $totalStockColumn : 0;
        if($totalStock < $insertDto['Amount']){
            return error_json('There is not enough stock at the source warehouse, there is: ' . $totalStock);
        }

        $entity = new DbModel\StockTransaction();
        $entity = $entity->fromArray($insertDto);

        $entity->save();

        $receivingLog = new DbModel\WarehouseProductStockLog();
        $receivingLog->setWarehouseId($entity->getToWarehouseId());
        $receivingLog->setProductId($entity->getProductId());
        $receivingLog->setAmount($entity->getAmount());
        $receivingLog->setIsReceived(true);

        $givingLog = new DbModel\WarehouseProductStockLog();
        $givingLog->setWarehouseId($entity->getFromWarehouseId());
        $givingLog->setProductId($entity->getProductId());
        $givingLog->setAmount($entity->getAmount());
        $givingLog->setIsReceived(false);

        $receivingLog->save();
        $givingLog->save();

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