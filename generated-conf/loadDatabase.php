<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMapFromDumps(array (
  'default' => 
  array (
    'tablesByName' => 
    array (
      'products' => '\\DbModel\\Map\\ProductTableMap',
      'stock_transactions' => '\\DbModel\\Map\\StockTransactionTableMap',
      'users' => '\\DbModel\\Map\\UserTableMap',
      'vehicles' => '\\DbModel\\Map\\VehicleTableMap',
      'warehouse_product_stock_log' => '\\DbModel\\Map\\WarehouseProductStockLogTableMap',
      'warehouses' => '\\DbModel\\Map\\WarehouseTableMap',
    ),
    'tablesByPhpName' => 
    array (
      '\\Product' => '\\DbModel\\Map\\ProductTableMap',
      '\\StockTransaction' => '\\DbModel\\Map\\StockTransactionTableMap',
      '\\User' => '\\DbModel\\Map\\UserTableMap',
      '\\Vehicle' => '\\DbModel\\Map\\VehicleTableMap',
      '\\Warehouse' => '\\DbModel\\Map\\WarehouseTableMap',
      '\\WarehouseProductStockLog' => '\\DbModel\\Map\\WarehouseProductStockLogTableMap',
    ),
  ),
));
