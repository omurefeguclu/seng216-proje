<?php

global $router;

use Propel\Runtime\ActiveQuery\Criteria;

$router->group('/api/vehicles')
    ->get('/form/{id}', function ($id) {
        $vehicle = DbModel\VehicleQuery::create()->findPk($id);
        if(!$vehicle){
            return error_json('Vehicle not found with id ' . $id);
        }

        return ok_json($vehicle->toArray());
    })
    ->post('/list', function (\Core\Http\RequestContext $ctx) {
        $searchDto = $ctx->json();

        $query = DbModel\VehicleQuery::create();
        if(isset($searchDto['PlateNumber'])){
            $query = $query->filterByPlateNumber('%' . $searchDto['PlateNumber'] . '%', \Propel\Runtime\ActiveQuery\Criteria::LIKE);
        }
        $pageIndex = $searchDto['PageIndex'] ?? 0;
        $pageSize = $searchDto['PageSize'] ?? 10;
        $result_list = $query->paginate($pageIndex + 1, $pageSize);

        return paginated_json($result_list);
    })
    ->post('/form', function(\Core\Http\RequestContext $ctx) {
        $insertDto = $ctx->json();

        $vehicle = new DbModel\Vehicle();
        $vehicle = $vehicle->fromArray($insertDto);

        $vehicle->save();

        return ok_json($vehicle->toArray());
    })
    ->post('/form/{id}', function($id, \Core\Http\RequestContext $ctx) {
        $vehicle = DbModel\VehicleQuery::create()->findPk($id);
        if(!$vehicle){
            return error_json('Vehicle not found with id ' . $id);
        }

        $insertDto = $ctx->json();

        $vehicle = $vehicle->fromArray($insertDto);
        $vehicle->save();

        return ok_json($vehicle->toArray());
    })
    ->get('/delete/{id}', function ($id) {

        $vehicle = DbModel\VehicleQuery::create()->findPk($id);
        if(!$vehicle){
            return error_json('Vehicle not found with id ' . $id);
        }

        $vehicle->delete();

        return ok_json();
    })
    ->get('/get-dropdown', function (){
        $vehicles = DbModel\VehicleQuery::create()
            ->orderByCreatedOn(Criteria::DESC)
            ->find();

        return dropdown_json($vehicles, fn($vehicle)=>$vehicle->getId(), fn($vehicle)=>$vehicle->getPlateNumber());
    })
    ->middleware([authMiddleware()]);

$router->group('/vehicles')
    ->get('/', function(){
        return view('list');
    })
    ->middleware([authMiddleware()]);