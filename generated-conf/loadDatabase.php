<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMapFromDumps(array (
  'default' => 
  array (
    'tablesByName' => 
    array (
      'products' => '\\DbModel\\Map\\ProductsTableMap',
      'stock_transactions' => '\\DbModel\\Map\\StockTransactionsTableMap',
      'users' => '\\DbModel\\Map\\UsersTableMap',
      'vehicles' => '\\DbModel\\Map\\VehiclesTableMap',
      'warehouse_product_stock' => '\\DbModel\\Map\\WarehouseProductStockTableMap',
      'warehouse_product_stock_log' => '\\DbModel\\Map\\WarehouseProductStockLogTableMap',
      'warehouses' => '\\DbModel\\Map\\WarehousesTableMap',
    ),
    'tablesByPhpName' => 
    array (
      '\\Products' => '\\DbModel\\Map\\ProductsTableMap',
      '\\StockTransactions' => '\\DbModel\\Map\\StockTransactionsTableMap',
      '\\Users' => '\\DbModel\\Map\\UsersTableMap',
      '\\Vehicles' => '\\DbModel\\Map\\VehiclesTableMap',
      '\\WarehouseProductStock' => '\\DbModel\\Map\\WarehouseProductStockTableMap',
      '\\WarehouseProductStockLog' => '\\DbModel\\Map\\WarehouseProductStockLogTableMap',
      '\\Warehouses' => '\\DbModel\\Map\\WarehousesTableMap',
    ),
  ),
));
