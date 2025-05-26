<?php

global $router;

$router->group('/dashboard')
->get('/', function (\Core\Http\RequestContext $ctx){

    $productCount = \DbModel\ProductQuery::create()->count();
    $vehicleCount  = \DbModel\VehicleQuery::create()->count();
    $warehouseCount = \DbModel\WarehouseQuery::create()->count();

    $model = [
        'TotalProducts' => $productCount,
        'TotalVehicles' => $vehicleCount,
        'TotalWarehouses' => $warehouseCount
    ];

    return view('dashboard', $model);
})
->middleware([authMiddleware()]);

