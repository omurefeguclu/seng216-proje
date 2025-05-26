<?php

namespace DbModel\Map;

use DbModel\StockTransaction;
use DbModel\StockTransactionQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'stock_transactions' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class StockTransactionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'DbModel.Map.StockTransactionTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'stock_transactions';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'StockTransaction';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\DbModel\\StockTransaction';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'DbModel.StockTransaction';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    public const COL_ID = 'stock_transactions.id';

    /**
     * the column name for the product_id field
     */
    public const COL_PRODUCT_ID = 'stock_transactions.product_id';

    /**
     * the column name for the from_warehouse_id field
     */
    public const COL_FROM_WAREHOUSE_ID = 'stock_transactions.from_warehouse_id';

    /**
     * the column name for the to_warehouse_id field
     */
    public const COL_TO_WAREHOUSE_ID = 'stock_transactions.to_warehouse_id';

    /**
     * the column name for the vehicle_id field
     */
    public const COL_VEHICLE_ID = 'stock_transactions.vehicle_id';

    /**
     * the column name for the creator_user_id field
     */
    public const COL_CREATOR_USER_ID = 'stock_transactions.creator_user_id';

    /**
     * the column name for the amount field
     */
    public const COL_AMOUNT = 'stock_transactions.amount';

    /**
     * the column name for the created_on field
     */
    public const COL_CREATED_ON = 'stock_transactions.created_on';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'ProductId', 'FromWarehouseId', 'ToWarehouseId', 'VehicleId', 'CreatorUserId', 'Amount', 'CreatedOn', ],
        self::TYPE_CAMELNAME     => ['id', 'productId', 'fromWarehouseId', 'toWarehouseId', 'vehicleId', 'creatorUserId', 'amount', 'createdOn', ],
        self::TYPE_COLNAME       => [StockTransactionTableMap::COL_ID, StockTransactionTableMap::COL_PRODUCT_ID, StockTransactionTableMap::COL_FROM_WAREHOUSE_ID, StockTransactionTableMap::COL_TO_WAREHOUSE_ID, StockTransactionTableMap::COL_VEHICLE_ID, StockTransactionTableMap::COL_CREATOR_USER_ID, StockTransactionTableMap::COL_AMOUNT, StockTransactionTableMap::COL_CREATED_ON, ],
        self::TYPE_FIELDNAME     => ['id', 'product_id', 'from_warehouse_id', 'to_warehouse_id', 'vehicle_id', 'creator_user_id', 'amount', 'created_on', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, ]
    ];

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     *
     * @var array<string, mixed>
     */
    protected static $fieldKeys = [
        self::TYPE_PHPNAME       => ['Id' => 0, 'ProductId' => 1, 'FromWarehouseId' => 2, 'ToWarehouseId' => 3, 'VehicleId' => 4, 'CreatorUserId' => 5, 'Amount' => 6, 'CreatedOn' => 7, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'productId' => 1, 'fromWarehouseId' => 2, 'toWarehouseId' => 3, 'vehicleId' => 4, 'creatorUserId' => 5, 'amount' => 6, 'createdOn' => 7, ],
        self::TYPE_COLNAME       => [StockTransactionTableMap::COL_ID => 0, StockTransactionTableMap::COL_PRODUCT_ID => 1, StockTransactionTableMap::COL_FROM_WAREHOUSE_ID => 2, StockTransactionTableMap::COL_TO_WAREHOUSE_ID => 3, StockTransactionTableMap::COL_VEHICLE_ID => 4, StockTransactionTableMap::COL_CREATOR_USER_ID => 5, StockTransactionTableMap::COL_AMOUNT => 6, StockTransactionTableMap::COL_CREATED_ON => 7, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'product_id' => 1, 'from_warehouse_id' => 2, 'to_warehouse_id' => 3, 'vehicle_id' => 4, 'creator_user_id' => 5, 'amount' => 6, 'created_on' => 7, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'StockTransaction.Id' => 'ID',
        'id' => 'ID',
        'stockTransaction.id' => 'ID',
        'StockTransactionTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'stock_transactions.id' => 'ID',
        'ProductId' => 'PRODUCT_ID',
        'StockTransaction.ProductId' => 'PRODUCT_ID',
        'productId' => 'PRODUCT_ID',
        'stockTransaction.productId' => 'PRODUCT_ID',
        'StockTransactionTableMap::COL_PRODUCT_ID' => 'PRODUCT_ID',
        'COL_PRODUCT_ID' => 'PRODUCT_ID',
        'product_id' => 'PRODUCT_ID',
        'stock_transactions.product_id' => 'PRODUCT_ID',
        'FromWarehouseId' => 'FROM_WAREHOUSE_ID',
        'StockTransaction.FromWarehouseId' => 'FROM_WAREHOUSE_ID',
        'fromWarehouseId' => 'FROM_WAREHOUSE_ID',
        'stockTransaction.fromWarehouseId' => 'FROM_WAREHOUSE_ID',
        'StockTransactionTableMap::COL_FROM_WAREHOUSE_ID' => 'FROM_WAREHOUSE_ID',
        'COL_FROM_WAREHOUSE_ID' => 'FROM_WAREHOUSE_ID',
        'from_warehouse_id' => 'FROM_WAREHOUSE_ID',
        'stock_transactions.from_warehouse_id' => 'FROM_WAREHOUSE_ID',
        'ToWarehouseId' => 'TO_WAREHOUSE_ID',
        'StockTransaction.ToWarehouseId' => 'TO_WAREHOUSE_ID',
        'toWarehouseId' => 'TO_WAREHOUSE_ID',
        'stockTransaction.toWarehouseId' => 'TO_WAREHOUSE_ID',
        'StockTransactionTableMap::COL_TO_WAREHOUSE_ID' => 'TO_WAREHOUSE_ID',
        'COL_TO_WAREHOUSE_ID' => 'TO_WAREHOUSE_ID',
        'to_warehouse_id' => 'TO_WAREHOUSE_ID',
        'stock_transactions.to_warehouse_id' => 'TO_WAREHOUSE_ID',
        'VehicleId' => 'VEHICLE_ID',
        'StockTransaction.VehicleId' => 'VEHICLE_ID',
        'vehicleId' => 'VEHICLE_ID',
        'stockTransaction.vehicleId' => 'VEHICLE_ID',
        'StockTransactionTableMap::COL_VEHICLE_ID' => 'VEHICLE_ID',
        'COL_VEHICLE_ID' => 'VEHICLE_ID',
        'vehicle_id' => 'VEHICLE_ID',
        'stock_transactions.vehicle_id' => 'VEHICLE_ID',
        'CreatorUserId' => 'CREATOR_USER_ID',
        'StockTransaction.CreatorUserId' => 'CREATOR_USER_ID',
        'creatorUserId' => 'CREATOR_USER_ID',
        'stockTransaction.creatorUserId' => 'CREATOR_USER_ID',
        'StockTransactionTableMap::COL_CREATOR_USER_ID' => 'CREATOR_USER_ID',
        'COL_CREATOR_USER_ID' => 'CREATOR_USER_ID',
        'creator_user_id' => 'CREATOR_USER_ID',
        'stock_transactions.creator_user_id' => 'CREATOR_USER_ID',
        'Amount' => 'AMOUNT',
        'StockTransaction.Amount' => 'AMOUNT',
        'amount' => 'AMOUNT',
        'stockTransaction.amount' => 'AMOUNT',
        'StockTransactionTableMap::COL_AMOUNT' => 'AMOUNT',
        'COL_AMOUNT' => 'AMOUNT',
        'stock_transactions.amount' => 'AMOUNT',
        'CreatedOn' => 'CREATED_ON',
        'StockTransaction.CreatedOn' => 'CREATED_ON',
        'createdOn' => 'CREATED_ON',
        'stockTransaction.createdOn' => 'CREATED_ON',
        'StockTransactionTableMap::COL_CREATED_ON' => 'CREATED_ON',
        'COL_CREATED_ON' => 'CREATED_ON',
        'created_on' => 'CREATED_ON',
        'stock_transactions.created_on' => 'CREATED_ON',
    ];

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function initialize(): void
    {
        // attributes
        $this->setName('stock_transactions');
        $this->setPhpName('StockTransaction');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\DbModel\\StockTransaction');
        $this->setPackage('DbModel');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('product_id', 'ProductId', 'INTEGER', 'products', 'id', true, null, null);
        $this->addForeignKey('from_warehouse_id', 'FromWarehouseId', 'INTEGER', 'warehouses', 'id', false, null, null);
        $this->addForeignKey('to_warehouse_id', 'ToWarehouseId', 'INTEGER', 'warehouses', 'id', false, null, null);
        $this->addForeignKey('vehicle_id', 'VehicleId', 'INTEGER', 'vehicles', 'id', false, null, null);
        $this->addForeignKey('creator_user_id', 'CreatorUserId', 'INTEGER', 'users', 'id', false, null, null);
        $this->addColumn('amount', 'Amount', 'INTEGER', true, null, null);
        $this->addColumn('created_on', 'CreatedOn', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('Product', '\\DbModel\\Product', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':product_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('WarehouseRelatedByFromWarehouseId', '\\DbModel\\Warehouse', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':from_warehouse_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('WarehouseRelatedByToWarehouseId', '\\DbModel\\Warehouse', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':to_warehouse_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Vehicle', '\\DbModel\\Vehicle', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':vehicle_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('User', '\\DbModel\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':creator_user_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('WarehouseProductStockLog', '\\DbModel\\WarehouseProductStockLog', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':related_transaction_id',
    1 => ':id',
  ),
), null, null, 'WarehouseProductStockLogs', false);
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string|null The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): ?string
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param bool $withPrefix Whether to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass(bool $withPrefix = true): string
    {
        return $withPrefix ? StockTransactionTableMap::CLASS_DEFAULT : StockTransactionTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array $row Row returned by DataFetcher->fetch().
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array (StockTransaction object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = StockTransactionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = StockTransactionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + StockTransactionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = StockTransactionTableMap::OM_CLASS;
            /** @var StockTransaction $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            StockTransactionTableMap::addInstanceToPool($obj, $key);
        }

        return [$obj, $col];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array<object>
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher): array
    {
        $results = [];

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = StockTransactionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = StockTransactionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var StockTransaction $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                StockTransactionTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria Object containing the columns to add.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function addSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->addSelectColumn(StockTransactionTableMap::COL_ID);
            $criteria->addSelectColumn(StockTransactionTableMap::COL_PRODUCT_ID);
            $criteria->addSelectColumn(StockTransactionTableMap::COL_FROM_WAREHOUSE_ID);
            $criteria->addSelectColumn(StockTransactionTableMap::COL_TO_WAREHOUSE_ID);
            $criteria->addSelectColumn(StockTransactionTableMap::COL_VEHICLE_ID);
            $criteria->addSelectColumn(StockTransactionTableMap::COL_CREATOR_USER_ID);
            $criteria->addSelectColumn(StockTransactionTableMap::COL_AMOUNT);
            $criteria->addSelectColumn(StockTransactionTableMap::COL_CREATED_ON);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.product_id');
            $criteria->addSelectColumn($alias . '.from_warehouse_id');
            $criteria->addSelectColumn($alias . '.to_warehouse_id');
            $criteria->addSelectColumn($alias . '.vehicle_id');
            $criteria->addSelectColumn($alias . '.creator_user_id');
            $criteria->addSelectColumn($alias . '.amount');
            $criteria->addSelectColumn($alias . '.created_on');
        }
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param Criteria $criteria Object containing the columns to remove.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function removeSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->removeSelectColumn(StockTransactionTableMap::COL_ID);
            $criteria->removeSelectColumn(StockTransactionTableMap::COL_PRODUCT_ID);
            $criteria->removeSelectColumn(StockTransactionTableMap::COL_FROM_WAREHOUSE_ID);
            $criteria->removeSelectColumn(StockTransactionTableMap::COL_TO_WAREHOUSE_ID);
            $criteria->removeSelectColumn(StockTransactionTableMap::COL_VEHICLE_ID);
            $criteria->removeSelectColumn(StockTransactionTableMap::COL_CREATOR_USER_ID);
            $criteria->removeSelectColumn(StockTransactionTableMap::COL_AMOUNT);
            $criteria->removeSelectColumn(StockTransactionTableMap::COL_CREATED_ON);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.product_id');
            $criteria->removeSelectColumn($alias . '.from_warehouse_id');
            $criteria->removeSelectColumn($alias . '.to_warehouse_id');
            $criteria->removeSelectColumn($alias . '.vehicle_id');
            $criteria->removeSelectColumn($alias . '.creator_user_id');
            $criteria->removeSelectColumn($alias . '.amount');
            $criteria->removeSelectColumn($alias . '.created_on');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap(): TableMap
    {
        return Propel::getServiceContainer()->getDatabaseMap(StockTransactionTableMap::DATABASE_NAME)->getTable(StockTransactionTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a StockTransaction or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or StockTransaction object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ?ConnectionInterface $con = null): int
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockTransactionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \DbModel\StockTransaction) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(StockTransactionTableMap::DATABASE_NAME);
            $criteria->add(StockTransactionTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = StockTransactionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            StockTransactionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                StockTransactionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the stock_transactions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return StockTransactionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a StockTransaction or Criteria object.
     *
     * @param mixed $criteria Criteria or StockTransaction object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockTransactionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from StockTransaction object
        }

        if ($criteria->containsKey(StockTransactionTableMap::COL_ID) && $criteria->keyContainsValue(StockTransactionTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.StockTransactionTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = StockTransactionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
