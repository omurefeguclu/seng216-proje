<?php

global $router;

$router->group('/api/vehicles')
    ->get('/get/{id}', function ($id) {
        $vehicle = DbModel\VehicleQuery::create()->findPk($id);
        if(!$vehicle){
            return error_json('Vehicle not found with id ' . $id);
        }

        return ok_json($vehicle);
    })
    ->post('/list', function (\Core\Http\RequestContext $ctx) {
        $searchDto = $ctx->json();

        $query = DbModel\VehicleQuery::create();
        if(isset($searchDto['PlateNumber'])){
            $query = $query->filterByPlateNumber($searchDto['PlateNumber']);
        }
        $result_list = $query->paginate();

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
        $vehicles = DbModel\VehicleQuery::create()->find();

        return dropdown_json($vehicles, fn($vehicle)=>$vehicle->getId(), fn($vehicle)=>$vehicle->getPlateNumber());
    });
    //->middleware([authMiddleware()]);

$router->group('/vehicles')
    ->get('/', function(){
        return view('list');
    });