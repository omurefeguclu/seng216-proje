<?php

namespace DbModel\Map;

use DbModel\WarehouseProductStockLog;
use DbModel\WarehouseProductStockLogQuery;
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
 * This class defines the structure of the 'warehouse_product_stock_log' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class WarehouseProductStockLogTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'DbModel.Map.WarehouseProductStockLogTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'warehouse_product_stock_log';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'WarehouseProductStockLog';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\DbModel\\WarehouseProductStockLog';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'DbModel.WarehouseProductStockLog';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the id field
     */
    public const COL_ID = 'warehouse_product_stock_log.id';

    /**
     * the column name for the warehouse_id field
     */
    public const COL_WAREHOUSE_ID = 'warehouse_product_stock_log.warehouse_id';

    /**
     * the column name for the product_id field
     */
    public const COL_PRODUCT_ID = 'warehouse_product_stock_log.product_id';

    /**
     * the column name for the related_transaction_id field
     */
    public const COL_RELATED_TRANSACTION_ID = 'warehouse_product_stock_log.related_transaction_id';

    /**
     * the column name for the amount field
     */
    public const COL_AMOUNT = 'warehouse_product_stock_log.amount';

    /**
     * the column name for the is_received field
     */
    public const COL_IS_RECEIVED = 'warehouse_product_stock_log.is_received';

    /**
     * the column name for the created_on field
     */
    public const COL_CREATED_ON = 'warehouse_product_stock_log.created_on';

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
        self::TYPE_PHPNAME       => ['Id', 'WarehouseId', 'ProductId', 'RelatedTransactionId', 'Amount', 'IsReceived', 'CreatedOn', ],
        self::TYPE_CAMELNAME     => ['id', 'warehouseId', 'productId', 'relatedTransactionId', 'amount', 'isReceived', 'createdOn', ],
        self::TYPE_COLNAME       => [WarehouseProductStockLogTableMap::COL_ID, WarehouseProductStockLogTableMap::COL_WAREHOUSE_ID, WarehouseProductStockLogTableMap::COL_PRODUCT_ID, WarehouseProductStockLogTableMap::COL_RELATED_TRANSACTION_ID, WarehouseProductStockLogTableMap::COL_AMOUNT, WarehouseProductStockLogTableMap::COL_IS_RECEIVED, WarehouseProductStockLogTableMap::COL_CREATED_ON, ],
        self::TYPE_FIELDNAME     => ['id', 'warehouse_id', 'product_id', 'related_transaction_id', 'amount', 'is_received', 'created_on', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, ]
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'WarehouseId' => 1, 'ProductId' => 2, 'RelatedTransactionId' => 3, 'Amount' => 4, 'IsReceived' => 5, 'CreatedOn' => 6, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'warehouseId' => 1, 'productId' => 2, 'relatedTransactionId' => 3, 'amount' => 4, 'isReceived' => 5, 'createdOn' => 6, ],
        self::TYPE_COLNAME       => [WarehouseProductStockLogTableMap::COL_ID => 0, WarehouseProductStockLogTableMap::COL_WAREHOUSE_ID => 1, WarehouseProductStockLogTableMap::COL_PRODUCT_ID => 2, WarehouseProductStockLogTableMap::COL_RELATED_TRANSACTION_ID => 3, WarehouseProductStockLogTableMap::COL_AMOUNT => 4, WarehouseProductStockLogTableMap::COL_IS_RECEIVED => 5, WarehouseProductStockLogTableMap::COL_CREATED_ON => 6, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'warehouse_id' => 1, 'product_id' => 2, 'related_transaction_id' => 3, 'amount' => 4, 'is_received' => 5, 'created_on' => 6, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'WarehouseProductStockLog.Id' => 'ID',
        'id' => 'ID',
        'warehouseProductStockLog.id' => 'ID',
        'WarehouseProductStockLogTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'warehouse_product_stock_log.id' => 'ID',
        'WarehouseId' => 'WAREHOUSE_ID',
        'WarehouseProductStockLog.WarehouseId' => 'WAREHOUSE_ID',
        'warehouseId' => 'WAREHOUSE_ID',
        'warehouseProductStockLog.warehouseId' => 'WAREHOUSE_ID',
        'WarehouseProductStockLogTableMap::COL_WAREHOUSE_ID' => 'WAREHOUSE_ID',
        'COL_WAREHOUSE_ID' => 'WAREHOUSE_ID',
        'warehouse_id' => 'WAREHOUSE_ID',
        'warehouse_product_stock_log.warehouse_id' => 'WAREHOUSE_ID',
        'ProductId' => 'PRODUCT_ID',
        'WarehouseProductStockLog.ProductId' => 'PRODUCT_ID',
        'productId' => 'PRODUCT_ID',
        'warehouseProductStockLog.productId' => 'PRODUCT_ID',
        'WarehouseProductStockLogTableMap::COL_PRODUCT_ID' => 'PRODUCT_ID',
        'COL_PRODUCT_ID' => 'PRODUCT_ID',
        'product_id' => 'PRODUCT_ID',
        'warehouse_product_stock_log.product_id' => 'PRODUCT_ID',
        'RelatedTransactionId' => 'RELATED_TRANSACTION_ID',
        'WarehouseProductStockLog.RelatedTransactionId' => 'RELATED_TRANSACTION_ID',
        'relatedTransactionId' => 'RELATED_TRANSACTION_ID',
        'warehouseProductStockLog.relatedTransactionId' => 'RELATED_TRANSACTION_ID',
        'WarehouseProductStockLogTableMap::COL_RELATED_TRANSACTION_ID' => 'RELATED_TRANSACTION_ID',
        'COL_RELATED_TRANSACTION_ID' => 'RELATED_TRANSACTION_ID',
        'related_transaction_id' => 'RELATED_TRANSACTION_ID',
        'warehouse_product_stock_log.related_transaction_id' => 'RELATED_TRANSACTION_ID',
        'Amount' => 'AMOUNT',
        'WarehouseProductStockLog.Amount' => 'AMOUNT',
        'amount' => 'AMOUNT',
        'warehouseProductStockLog.amount' => 'AMOUNT',
        'WarehouseProductStockLogTableMap::COL_AMOUNT' => 'AMOUNT',
        'COL_AMOUNT' => 'AMOUNT',
        'warehouse_product_stock_log.amount' => 'AMOUNT',
        'IsReceived' => 'IS_RECEIVED',
        'WarehouseProductStockLog.IsReceived' => 'IS_RECEIVED',
        'isReceived' => 'IS_RECEIVED',
        'warehouseProductStockLog.isReceived' => 'IS_RECEIVED',
        'WarehouseProductStockLogTableMap::COL_IS_RECEIVED' => 'IS_RECEIVED',
        'COL_IS_RECEIVED' => 'IS_RECEIVED',
        'is_received' => 'IS_RECEIVED',
        'warehouse_product_stock_log.is_received' => 'IS_RECEIVED',
        'CreatedOn' => 'CREATED_ON',
        'WarehouseProductStockLog.CreatedOn' => 'CREATED_ON',
        'createdOn' => 'CREATED_ON',
        'warehouseProductStockLog.createdOn' => 'CREATED_ON',
        'WarehouseProductStockLogTableMap::COL_CREATED_ON' => 'CREATED_ON',
        'COL_CREATED_ON' => 'CREATED_ON',
        'created_on' => 'CREATED_ON',
        'warehouse_product_stock_log.created_on' => 'CREATED_ON',
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
        $this->setName('warehouse_product_stock_log');
        $this->setPhpName('WarehouseProductStockLog');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\DbModel\\WarehouseProductStockLog');
        $this->setPackage('DbModel');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('warehouse_id', 'WarehouseId', 'INTEGER', 'warehouses', 'id', true, null, null);
        $this->addForeignKey('product_id', 'ProductId', 'INTEGER', 'products', 'id', true, null, null);
        $this->addForeignKey('related_transaction_id', 'RelatedTransactionId', 'INTEGER', 'stock_transactions', 'id', false, null, null);
        $this->addColumn('amount', 'Amount', 'INTEGER', true, null, null);
        $this->addColumn('is_received', 'IsReceived', 'BOOLEAN', true, 1, null);
        $this->addColumn('created_on', 'CreatedOn', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('Warehouse', '\\DbModel\\Warehouse', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':warehouse_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Product', '\\DbModel\\Product', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':product_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('StockTransaction', '\\DbModel\\StockTransaction', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':related_transaction_id',
    1 => ':id',
  ),
), null, null, null, false);
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
        return $withPrefix ? WarehouseProductStockLogTableMap::CLASS_DEFAULT : WarehouseProductStockLogTableMap::OM_CLASS;
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
     * @return array (WarehouseProductStockLog object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = WarehouseProductStockLogTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = WarehouseProductStockLogTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + WarehouseProductStockLogTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = WarehouseProductStockLogTableMap::OM_CLASS;
            /** @var WarehouseProductStockLog $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            WarehouseProductStockLogTableMap::addInstanceToPool($obj, $key);
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
            $key = WarehouseProductStockLogTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = WarehouseProductStockLogTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var WarehouseProductStockLog $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                WarehouseProductStockLogTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(WarehouseProductStockLogTableMap::COL_ID);
            $criteria->addSelectColumn(WarehouseProductStockLogTableMap::COL_WAREHOUSE_ID);
            $criteria->addSelectColumn(WarehouseProductStockLogTableMap::COL_PRODUCT_ID);
            $criteria->addSelectColumn(WarehouseProductStockLogTableMap::COL_RELATED_TRANSACTION_ID);
            $criteria->addSelectColumn(WarehouseProductStockLogTableMap::COL_AMOUNT);
            $criteria->addSelectColumn(WarehouseProductStockLogTableMap::COL_IS_RECEIVED);
            $criteria->addSelectColumn(WarehouseProductStockLogTableMap::COL_CREATED_ON);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.warehouse_id');
            $criteria->addSelectColumn($alias . '.product_id');
            $criteria->addSelectColumn($alias . '.related_transaction_id');
            $criteria->addSelectColumn($alias . '.amount');
            $criteria->addSelectColumn($alias . '.is_received');
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
            $criteria->removeSelectColumn(WarehouseProductStockLogTableMap::COL_ID);
            $criteria->removeSelectColumn(WarehouseProductStockLogTableMap::COL_WAREHOUSE_ID);
            $criteria->removeSelectColumn(WarehouseProductStockLogTableMap::COL_PRODUCT_ID);
            $criteria->removeSelectColumn(WarehouseProductStockLogTableMap::COL_RELATED_TRANSACTION_ID);
            $criteria->removeSelectColumn(WarehouseProductStockLogTableMap::COL_AMOUNT);
            $criteria->removeSelectColumn(WarehouseProductStockLogTableMap::COL_IS_RECEIVED);
            $criteria->removeSelectColumn(WarehouseProductStockLogTableMap::COL_CREATED_ON);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.warehouse_id');
            $criteria->removeSelectColumn($alias . '.product_id');
            $criteria->removeSelectColumn($alias . '.related_transaction_id');
            $criteria->removeSelectColumn($alias . '.amount');
            $criteria->removeSelectColumn($alias . '.is_received');
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
        return Propel::getServiceContainer()->getDatabaseMap(WarehouseProductStockLogTableMap::DATABASE_NAME)->getTable(WarehouseProductStockLogTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a WarehouseProductStockLog or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or WarehouseProductStockLog object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(WarehouseProductStockLogTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \DbModel\WarehouseProductStockLog) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(WarehouseProductStockLogTableMap::DATABASE_NAME);
            $criteria->add(WarehouseProductStockLogTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = WarehouseProductStockLogQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            WarehouseProductStockLogTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                WarehouseProductStockLogTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the warehouse_product_stock_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return WarehouseProductStockLogQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a WarehouseProductStockLog or Criteria object.
     *
     * @param mixed $criteria Criteria or WarehouseProductStockLog object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WarehouseProductStockLogTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from WarehouseProductStockLog object
        }

        if ($criteria->containsKey(WarehouseProductStockLogTableMap::COL_ID) && $criteria->keyContainsValue(WarehouseProductStockLogTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.WarehouseProductStockLogTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = WarehouseProductStockLogQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
