<?php

namespace DbModel\Base;

use \DateTime;
use \Exception;
use \PDO;
use DbModel\Products as ChildProducts;
use DbModel\ProductsQuery as ChildProductsQuery;
use DbModel\StockTransactions as ChildStockTransactions;
use DbModel\StockTransactionsQuery as ChildStockTransactionsQuery;
use DbModel\WarehouseProductStock as ChildWarehouseProductStock;
use DbModel\WarehouseProductStockLog as ChildWarehouseProductStockLog;
use DbModel\WarehouseProductStockLogQuery as ChildWarehouseProductStockLogQuery;
use DbModel\WarehouseProductStockQuery as ChildWarehouseProductStockQuery;
use DbModel\Map\ProductsTableMap;
use DbModel\Map\StockTransactionsTableMap;
use DbModel\Map\WarehouseProductStockLogTableMap;
use DbModel\Map\WarehouseProductStockTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'products' table.
 *
 *
 *
 * @package    propel.generator.DbModel.Base
 */
abstract class Products implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\DbModel\\Map\\ProductsTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var bool
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var bool
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = [];

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = [];

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the created_on field.
     *
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        DateTime
     */
    protected $created_on;

    /**
     * @var        ObjectCollection|ChildStockTransactions[] Collection to store aggregation of ChildStockTransactions objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildStockTransactions> Collection to store aggregation of ChildStockTransactions objects.
     */
    protected $collStockTransactionss;
    protected $collStockTransactionssPartial;

    /**
     * @var        ObjectCollection|ChildWarehouseProductStock[] Collection to store aggregation of ChildWarehouseProductStock objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildWarehouseProductStock> Collection to store aggregation of ChildWarehouseProductStock objects.
     */
    protected $collWarehouseProductStocks;
    protected $collWarehouseProductStocksPartial;

    /**
     * @var        ObjectCollection|ChildWarehouseProductStockLog[] Collection to store aggregation of ChildWarehouseProductStockLog objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildWarehouseProductStockLog> Collection to store aggregation of ChildWarehouseProductStockLog objects.
     */
    protected $collWarehouseProductStockLogs;
    protected $collWarehouseProductStockLogsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var bool
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStockTransactions[]
     * @phpstan-var ObjectCollection&\Traversable<ChildStockTransactions>
     */
    protected $stockTransactionssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildWarehouseProductStock[]
     * @phpstan-var ObjectCollection&\Traversable<ChildWarehouseProductStock>
     */
    protected $warehouseProductStocksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildWarehouseProductStockLog[]
     * @phpstan-var ObjectCollection&\Traversable<ChildWarehouseProductStockLog>
     */
    protected $warehouseProductStockLogsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues(): void
    {
    }

    /**
     * Initializes internal state of DbModel\Base\Products object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return bool True if the object has been modified.
     */
    public function isModified(): bool
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param string $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return bool True if $col has been modified.
     */
    public function isColumnModified(string $col): bool
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns(): array
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return bool True, if the object has never been persisted.
     */
    public function isNew(): bool
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param bool $b the state of the object.
     */
    public function setNew(bool $b): void
    {
        $this->new = $b;
    }

    /**
     * Whether this object has been deleted.
     * @return bool The deleted state of this object.
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param bool $b The deleted state of this object.
     * @return void
     */
    public function setDeleted(bool $b): void
    {
        $this->deleted = $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified(?string $col = null): void
    {
        if (null !== $col) {
            unset($this->modifiedColumns[$col]);
        } else {
            $this->modifiedColumns = [];
        }
    }

    /**
     * Compares this with another <code>Products</code> instance.  If
     * <code>obj</code> is an instance of <code>Products</code>, delegates to
     * <code>equals(Products)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param mixed $obj The object to compare to.
     * @return bool Whether equal to the object specified.
     */
    public function equals($obj): bool
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns(): array
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return bool
     */
    public function hasVirtualColumn(string $name): bool
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return mixed
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getVirtualColumn(string $name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of nonexistent virtual column `%s`.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @param mixed $value The value to give to the virtual column
     *
     * @return $this The current object, for fluid interface
     */
    public function setVirtualColumn(string $name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param string $msg
     * @param int $priority One of the Propel::LOG_* logging levels
     * @return void
     */
    protected function log(string $msg, int $priority = Propel::LOG_INFO): void
    {
        Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param \Propel\Runtime\Parser\AbstractParser|string $parser An AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME, TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM. Defaults to TableMap::TYPE_PHPNAME.
     * @return string The exported data
     */
    public function exportTo($parser, bool $includeLazyLoadColumns = true, string $keyType = TableMap::TYPE_PHPNAME): string
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray($keyType, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     *
     * @return array<string>
     */
    public function __sleep(): array
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [optionally formatted] temporal [created_on] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), and 0 if column value is 0000-00-00 00:00:00.
     *
     * @throws \Propel\Runtime\Exception\PropelException - if unable to parse/validate the date/time value.
     *
     * @psalm-return ($format is null ? DateTime : string)
     */
    public function getCreatedOn($format = null)
    {
        if ($format === null) {
            return $this->created_on;
        } else {
            return $this->created_on instanceof \DateTimeInterface ? $this->created_on->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ProductsTableMap::COL_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [name] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[ProductsTableMap::COL_NAME] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [created_on] column to a normalized version of the date/time value specified.
     *
     * @param string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this The current object (for fluent API support)
     */
    public function setCreatedOn($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_on !== null || $dt !== null) {
            if ($this->created_on === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_on->format("Y-m-d H:i:s.u")) {
                $this->created_on = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ProductsTableMap::COL_CREATED_ON] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return bool Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues(): bool
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    }

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by DataFetcher->fetch().
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param bool $rehydrate Whether this object is being re-hydrated from the database.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int next starting column
     * @throws \Propel\Runtime\Exception\PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate(array $row, int $startcol = 0, bool $rehydrate = false, string $indexType = TableMap::TYPE_NUM): int
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ProductsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ProductsTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ProductsTableMap::translateFieldName('CreatedOn', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_on = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = ProductsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\DbModel\\Products'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function ensureConsistency(): void
    {
    }

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param bool $deep (optional) Whether to also de-associated any related objects.
     * @param ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload(bool $deep = false, ?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProductsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildProductsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collStockTransactionss = null;

            $this->collWarehouseProductStocks = null;

            $this->collWarehouseProductStockLogs = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see Products::setDeleted()
     * @see Products::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildProductsQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    public function save(?ConnectionInterface $con = null): int
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductsTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ProductsTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con): int
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->stockTransactionssScheduledForDeletion !== null) {
                if (!$this->stockTransactionssScheduledForDeletion->isEmpty()) {
                    \DbModel\StockTransactionsQuery::create()
                        ->filterByPrimaryKeys($this->stockTransactionssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->stockTransactionssScheduledForDeletion = null;
                }
            }

            if ($this->collStockTransactionss !== null) {
                foreach ($this->collStockTransactionss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->warehouseProductStocksScheduledForDeletion !== null) {
                if (!$this->warehouseProductStocksScheduledForDeletion->isEmpty()) {
                    \DbModel\WarehouseProductStockQuery::create()
                        ->filterByPrimaryKeys($this->warehouseProductStocksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->warehouseProductStocksScheduledForDeletion = null;
                }
            }

            if ($this->collWarehouseProductStocks !== null) {
                foreach ($this->collWarehouseProductStocks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->warehouseProductStockLogsScheduledForDeletion !== null) {
                if (!$this->warehouseProductStockLogsScheduledForDeletion->isEmpty()) {
                    \DbModel\WarehouseProductStockLogQuery::create()
                        ->filterByPrimaryKeys($this->warehouseProductStockLogsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->warehouseProductStockLogsScheduledForDeletion = null;
                }
            }

            if ($this->collWarehouseProductStockLogs !== null) {
                foreach ($this->collWarehouseProductStockLogs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    }

    /**
     * Insert the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con): void
    {
        $modifiedColumns = [];
        $index = 0;

        $this->modifiedColumns[ProductsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProductsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProductsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ProductsTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'NAME';
        }
        if ($this->isColumnModified(ProductsTableMap::COL_CREATED_ON)) {
            $modifiedColumns[':p' . $index++]  = 'created_on';
        }

        $sql = sprintf(
            'INSERT INTO products (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);

                        break;
                    case 'NAME':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);

                        break;
                    case 'created_on':
                        $stmt->bindValue($identifier, $this->created_on ? $this->created_on->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);

                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @return int Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con): int
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName(string $name, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ProductsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos Position in XML schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition(int $pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();

            case 1:
                return $this->getName();

            case 2:
                return $this->getCreatedOn();

            default:
                return null;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param bool $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array An associative array containing the field names (as keys) and field values
     */
    public function toArray(string $keyType = TableMap::TYPE_PHPNAME, bool $includeLazyLoadColumns = true, array $alreadyDumpedObjects = [], bool $includeForeignObjects = false): array
    {
        if (isset($alreadyDumpedObjects['Products'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Products'][$this->hashCode()] = true;
        $keys = ProductsTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getCreatedOn(),
        ];
        if ($result[$keys[2]] instanceof \DateTimeInterface) {
            $result[$keys[2]] = $result[$keys[2]]->format('Y-m-d H:i:s.u');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collStockTransactionss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'stockTransactionss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'stock_transactionss';
                        break;
                    default:
                        $key = 'StockTransactionss';
                }

                $result[$key] = $this->collStockTransactionss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collWarehouseProductStocks) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'warehouseProductStocks';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'warehouse_product_stocks';
                        break;
                    default:
                        $key = 'WarehouseProductStocks';
                }

                $result[$key] = $this->collWarehouseProductStocks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collWarehouseProductStockLogs) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'warehouseProductStockLogs';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'warehouse_product_stock_logs';
                        break;
                    default:
                        $key = 'WarehouseProductStockLogs';
                }

                $result[$key] = $this->collWarehouseProductStockLogs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this
     */
    public function setByName(string $name, $value, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ProductsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        $this->setByPosition($pos, $value);

        return $this;
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return $this
     */
    public function setByPosition(int $pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setCreatedOn($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param array $arr An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return $this
     */
    public function fromArray(array $arr, string $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = ProductsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCreatedOn($arr[$keys[2]]);
        }

        return $this;
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this The current object, for fluid interface
     */
    public function importFrom($parser, string $data, string $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria(): Criteria
    {
        $criteria = new Criteria(ProductsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ProductsTableMap::COL_ID)) {
            $criteria->add(ProductsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ProductsTableMap::COL_NAME)) {
            $criteria->add(ProductsTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(ProductsTableMap::COL_CREATED_ON)) {
            $criteria->add(ProductsTableMap::COL_CREATED_ON, $this->created_on);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria(): Criteria
    {
        $criteria = ChildProductsQuery::create();
        $criteria->add(ProductsTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int|string Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param int|null $key Primary key.
     * @return void
     */
    public function setPrimaryKey(?int $key = null): void
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \DbModel\Products (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setName($this->getName());
        $copyObj->setCreatedOn($this->getCreatedOn());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getStockTransactionss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStockTransactions($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getWarehouseProductStocks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addWarehouseProductStock($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getWarehouseProductStockLogs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addWarehouseProductStockLog($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \DbModel\Products Clone of current object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function copy(bool $deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName): void
    {
        if ('StockTransactions' === $relationName) {
            $this->initStockTransactionss();
            return;
        }
        if ('WarehouseProductStock' === $relationName) {
            $this->initWarehouseProductStocks();
            return;
        }
        if ('WarehouseProductStockLog' === $relationName) {
            $this->initWarehouseProductStockLogs();
            return;
        }
    }

    /**
     * Clears out the collStockTransactionss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addStockTransactionss()
     */
    public function clearStockTransactionss()
    {
        $this->collStockTransactionss = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collStockTransactionss collection loaded partially.
     *
     * @return void
     */
    public function resetPartialStockTransactionss($v = true): void
    {
        $this->collStockTransactionssPartial = $v;
    }

    /**
     * Initializes the collStockTransactionss collection.
     *
     * By default this just sets the collStockTransactionss collection to an empty array (like clearcollStockTransactionss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStockTransactionss(bool $overrideExisting = true): void
    {
        if (null !== $this->collStockTransactionss && !$overrideExisting) {
            return;
        }

        $collectionClassName = StockTransactionsTableMap::getTableMap()->getCollectionClassName();

        $this->collStockTransactionss = new $collectionClassName;
        $this->collStockTransactionss->setModel('\DbModel\StockTransactions');
    }

    /**
     * Gets an array of ChildStockTransactions objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProducts is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStockTransactions[] List of ChildStockTransactions objects
     * @phpstan-return ObjectCollection&\Traversable<ChildStockTransactions> List of ChildStockTransactions objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getStockTransactionss(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collStockTransactionssPartial && !$this->isNew();
        if (null === $this->collStockTransactionss || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collStockTransactionss) {
                    $this->initStockTransactionss();
                } else {
                    $collectionClassName = StockTransactionsTableMap::getTableMap()->getCollectionClassName();

                    $collStockTransactionss = new $collectionClassName;
                    $collStockTransactionss->setModel('\DbModel\StockTransactions');

                    return $collStockTransactionss;
                }
            } else {
                $collStockTransactionss = ChildStockTransactionsQuery::create(null, $criteria)
                    ->filterByProducts($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStockTransactionssPartial && count($collStockTransactionss)) {
                        $this->initStockTransactionss(false);

                        foreach ($collStockTransactionss as $obj) {
                            if (false == $this->collStockTransactionss->contains($obj)) {
                                $this->collStockTransactionss->append($obj);
                            }
                        }

                        $this->collStockTransactionssPartial = true;
                    }

                    return $collStockTransactionss;
                }

                if ($partial && $this->collStockTransactionss) {
                    foreach ($this->collStockTransactionss as $obj) {
                        if ($obj->isNew()) {
                            $collStockTransactionss[] = $obj;
                        }
                    }
                }

                $this->collStockTransactionss = $collStockTransactionss;
                $this->collStockTransactionssPartial = false;
            }
        }

        return $this->collStockTransactionss;
    }

    /**
     * Sets a collection of ChildStockTransactions objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $stockTransactionss A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setStockTransactionss(Collection $stockTransactionss, ?ConnectionInterface $con = null)
    {
        /** @var ChildStockTransactions[] $stockTransactionssToDelete */
        $stockTransactionssToDelete = $this->getStockTransactionss(new Criteria(), $con)->diff($stockTransactionss);


        $this->stockTransactionssScheduledForDeletion = $stockTransactionssToDelete;

        foreach ($stockTransactionssToDelete as $stockTransactionsRemoved) {
            $stockTransactionsRemoved->setProducts(null);
        }

        $this->collStockTransactionss = null;
        foreach ($stockTransactionss as $stockTransactions) {
            $this->addStockTransactions($stockTransactions);
        }

        $this->collStockTransactionss = $stockTransactionss;
        $this->collStockTransactionssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related StockTransactions objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related StockTransactions objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countStockTransactionss(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collStockTransactionssPartial && !$this->isNew();
        if (null === $this->collStockTransactionss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStockTransactionss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStockTransactionss());
            }

            $query = ChildStockTransactionsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProducts($this)
                ->count($con);
        }

        return count($this->collStockTransactionss);
    }

    /**
     * Method called to associate a ChildStockTransactions object to this object
     * through the ChildStockTransactions foreign key attribute.
     *
     * @param ChildStockTransactions $l ChildStockTransactions
     * @return $this The current object (for fluent API support)
     */
    public function addStockTransactions(ChildStockTransactions $l)
    {
        if ($this->collStockTransactionss === null) {
            $this->initStockTransactionss();
            $this->collStockTransactionssPartial = true;
        }

        if (!$this->collStockTransactionss->contains($l)) {
            $this->doAddStockTransactions($l);

            if ($this->stockTransactionssScheduledForDeletion and $this->stockTransactionssScheduledForDeletion->contains($l)) {
                $this->stockTransactionssScheduledForDeletion->remove($this->stockTransactionssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildStockTransactions $stockTransactions The ChildStockTransactions object to add.
     */
    protected function doAddStockTransactions(ChildStockTransactions $stockTransactions): void
    {
        $this->collStockTransactionss[]= $stockTransactions;
        $stockTransactions->setProducts($this);
    }

    /**
     * @param ChildStockTransactions $stockTransactions The ChildStockTransactions object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeStockTransactions(ChildStockTransactions $stockTransactions)
    {
        if ($this->getStockTransactionss()->contains($stockTransactions)) {
            $pos = $this->collStockTransactionss->search($stockTransactions);
            $this->collStockTransactionss->remove($pos);
            if (null === $this->stockTransactionssScheduledForDeletion) {
                $this->stockTransactionssScheduledForDeletion = clone $this->collStockTransactionss;
                $this->stockTransactionssScheduledForDeletion->clear();
            }
            $this->stockTransactionssScheduledForDeletion[]= clone $stockTransactions;
            $stockTransactions->setProducts(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Products is new, it will return
     * an empty collection; or if this Products has previously
     * been saved, it will retrieve related StockTransactionss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Products.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStockTransactions[] List of ChildStockTransactions objects
     * @phpstan-return ObjectCollection&\Traversable<ChildStockTransactions}> List of ChildStockTransactions objects
     */
    public function getStockTransactionssJoinWarehousesRelatedByFromWarehouseId(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStockTransactionsQuery::create(null, $criteria);
        $query->joinWith('WarehousesRelatedByFromWarehouseId', $joinBehavior);

        return $this->getStockTransactionss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Products is new, it will return
     * an empty collection; or if this Products has previously
     * been saved, it will retrieve related StockTransactionss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Products.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStockTransactions[] List of ChildStockTransactions objects
     * @phpstan-return ObjectCollection&\Traversable<ChildStockTransactions}> List of ChildStockTransactions objects
     */
    public function getStockTransactionssJoinWarehousesRelatedByToWarehouseId(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStockTransactionsQuery::create(null, $criteria);
        $query->joinWith('WarehousesRelatedByToWarehouseId', $joinBehavior);

        return $this->getStockTransactionss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Products is new, it will return
     * an empty collection; or if this Products has previously
     * been saved, it will retrieve related StockTransactionss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Products.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStockTransactions[] List of ChildStockTransactions objects
     * @phpstan-return ObjectCollection&\Traversable<ChildStockTransactions}> List of ChildStockTransactions objects
     */
    public function getStockTransactionssJoinVehicles(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStockTransactionsQuery::create(null, $criteria);
        $query->joinWith('Vehicles', $joinBehavior);

        return $this->getStockTransactionss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Products is new, it will return
     * an empty collection; or if this Products has previously
     * been saved, it will retrieve related StockTransactionss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Products.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStockTransactions[] List of ChildStockTransactions objects
     * @phpstan-return ObjectCollection&\Traversable<ChildStockTransactions}> List of ChildStockTransactions objects
     */
    public function getStockTransactionssJoinUsers(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStockTransactionsQuery::create(null, $criteria);
        $query->joinWith('Users', $joinBehavior);

        return $this->getStockTransactionss($query, $con);
    }

    /**
     * Clears out the collWarehouseProductStocks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addWarehouseProductStocks()
     */
    public function clearWarehouseProductStocks()
    {
        $this->collWarehouseProductStocks = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collWarehouseProductStocks collection loaded partially.
     *
     * @return void
     */
    public function resetPartialWarehouseProductStocks($v = true): void
    {
        $this->collWarehouseProductStocksPartial = $v;
    }

    /**
     * Initializes the collWarehouseProductStocks collection.
     *
     * By default this just sets the collWarehouseProductStocks collection to an empty array (like clearcollWarehouseProductStocks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initWarehouseProductStocks(bool $overrideExisting = true): void
    {
        if (null !== $this->collWarehouseProductStocks && !$overrideExisting) {
            return;
        }

        $collectionClassName = WarehouseProductStockTableMap::getTableMap()->getCollectionClassName();

        $this->collWarehouseProductStocks = new $collectionClassName;
        $this->collWarehouseProductStocks->setModel('\DbModel\WarehouseProductStock');
    }

    /**
     * Gets an array of ChildWarehouseProductStock objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProducts is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildWarehouseProductStock[] List of ChildWarehouseProductStock objects
     * @phpstan-return ObjectCollection&\Traversable<ChildWarehouseProductStock> List of ChildWarehouseProductStock objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getWarehouseProductStocks(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collWarehouseProductStocksPartial && !$this->isNew();
        if (null === $this->collWarehouseProductStocks || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collWarehouseProductStocks) {
                    $this->initWarehouseProductStocks();
                } else {
                    $collectionClassName = WarehouseProductStockTableMap::getTableMap()->getCollectionClassName();

                    $collWarehouseProductStocks = new $collectionClassName;
                    $collWarehouseProductStocks->setModel('\DbModel\WarehouseProductStock');

                    return $collWarehouseProductStocks;
                }
            } else {
                $collWarehouseProductStocks = ChildWarehouseProductStockQuery::create(null, $criteria)
                    ->filterByProducts($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collWarehouseProductStocksPartial && count($collWarehouseProductStocks)) {
                        $this->initWarehouseProductStocks(false);

                        foreach ($collWarehouseProductStocks as $obj) {
                            if (false == $this->collWarehouseProductStocks->contains($obj)) {
                                $this->collWarehouseProductStocks->append($obj);
                            }
                        }

                        $this->collWarehouseProductStocksPartial = true;
                    }

                    return $collWarehouseProductStocks;
                }

                if ($partial && $this->collWarehouseProductStocks) {
                    foreach ($this->collWarehouseProductStocks as $obj) {
                        if ($obj->isNew()) {
                            $collWarehouseProductStocks[] = $obj;
                        }
                    }
                }

                $this->collWarehouseProductStocks = $collWarehouseProductStocks;
                $this->collWarehouseProductStocksPartial = false;
            }
        }

        return $this->collWarehouseProductStocks;
    }

    /**
     * Sets a collection of ChildWarehouseProductStock objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $warehouseProductStocks A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setWarehouseProductStocks(Collection $warehouseProductStocks, ?ConnectionInterface $con = null)
    {
        /** @var ChildWarehouseProductStock[] $warehouseProductStocksToDelete */
        $warehouseProductStocksToDelete = $this->getWarehouseProductStocks(new Criteria(), $con)->diff($warehouseProductStocks);


        $this->warehouseProductStocksScheduledForDeletion = $warehouseProductStocksToDelete;

        foreach ($warehouseProductStocksToDelete as $warehouseProductStockRemoved) {
            $warehouseProductStockRemoved->setProducts(null);
        }

        $this->collWarehouseProductStocks = null;
        foreach ($warehouseProductStocks as $warehouseProductStock) {
            $this->addWarehouseProductStock($warehouseProductStock);
        }

        $this->collWarehouseProductStocks = $warehouseProductStocks;
        $this->collWarehouseProductStocksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related WarehouseProductStock objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related WarehouseProductStock objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countWarehouseProductStocks(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collWarehouseProductStocksPartial && !$this->isNew();
        if (null === $this->collWarehouseProductStocks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collWarehouseProductStocks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getWarehouseProductStocks());
            }

            $query = ChildWarehouseProductStockQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProducts($this)
                ->count($con);
        }

        return count($this->collWarehouseProductStocks);
    }

    /**
     * Method called to associate a ChildWarehouseProductStock object to this object
     * through the ChildWarehouseProductStock foreign key attribute.
     *
     * @param ChildWarehouseProductStock $l ChildWarehouseProductStock
     * @return $this The current object (for fluent API support)
     */
    public function addWarehouseProductStock(ChildWarehouseProductStock $l)
    {
        if ($this->collWarehouseProductStocks === null) {
            $this->initWarehouseProductStocks();
            $this->collWarehouseProductStocksPartial = true;
        }

        if (!$this->collWarehouseProductStocks->contains($l)) {
            $this->doAddWarehouseProductStock($l);

            if ($this->warehouseProductStocksScheduledForDeletion and $this->warehouseProductStocksScheduledForDeletion->contains($l)) {
                $this->warehouseProductStocksScheduledForDeletion->remove($this->warehouseProductStocksScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildWarehouseProductStock $warehouseProductStock The ChildWarehouseProductStock object to add.
     */
    protected function doAddWarehouseProductStock(ChildWarehouseProductStock $warehouseProductStock): void
    {
        $this->collWarehouseProductStocks[]= $warehouseProductStock;
        $warehouseProductStock->setProducts($this);
    }

    /**
     * @param ChildWarehouseProductStock $warehouseProductStock The ChildWarehouseProductStock object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeWarehouseProductStock(ChildWarehouseProductStock $warehouseProductStock)
    {
        if ($this->getWarehouseProductStocks()->contains($warehouseProductStock)) {
            $pos = $this->collWarehouseProductStocks->search($warehouseProductStock);
            $this->collWarehouseProductStocks->remove($pos);
            if (null === $this->warehouseProductStocksScheduledForDeletion) {
                $this->warehouseProductStocksScheduledForDeletion = clone $this->collWarehouseProductStocks;
                $this->warehouseProductStocksScheduledForDeletion->clear();
            }
            $this->warehouseProductStocksScheduledForDeletion[]= clone $warehouseProductStock;
            $warehouseProductStock->setProducts(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Products is new, it will return
     * an empty collection; or if this Products has previously
     * been saved, it will retrieve related WarehouseProductStocks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Products.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildWarehouseProductStock[] List of ChildWarehouseProductStock objects
     * @phpstan-return ObjectCollection&\Traversable<ChildWarehouseProductStock}> List of ChildWarehouseProductStock objects
     */
    public function getWarehouseProductStocksJoinWarehouses(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildWarehouseProductStockQuery::create(null, $criteria);
        $query->joinWith('Warehouses', $joinBehavior);

        return $this->getWarehouseProductStocks($query, $con);
    }

    /**
     * Clears out the collWarehouseProductStockLogs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addWarehouseProductStockLogs()
     */
    public function clearWarehouseProductStockLogs()
    {
        $this->collWarehouseProductStockLogs = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collWarehouseProductStockLogs collection loaded partially.
     *
     * @return void
     */
    public function resetPartialWarehouseProductStockLogs($v = true): void
    {
        $this->collWarehouseProductStockLogsPartial = $v;
    }

    /**
     * Initializes the collWarehouseProductStockLogs collection.
     *
     * By default this just sets the collWarehouseProductStockLogs collection to an empty array (like clearcollWarehouseProductStockLogs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initWarehouseProductStockLogs(bool $overrideExisting = true): void
    {
        if (null !== $this->collWarehouseProductStockLogs && !$overrideExisting) {
            return;
        }

        $collectionClassName = WarehouseProductStockLogTableMap::getTableMap()->getCollectionClassName();

        $this->collWarehouseProductStockLogs = new $collectionClassName;
        $this->collWarehouseProductStockLogs->setModel('\DbModel\WarehouseProductStockLog');
    }

    /**
     * Gets an array of ChildWarehouseProductStockLog objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProducts is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildWarehouseProductStockLog[] List of ChildWarehouseProductStockLog objects
     * @phpstan-return ObjectCollection&\Traversable<ChildWarehouseProductStockLog> List of ChildWarehouseProductStockLog objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getWarehouseProductStockLogs(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collWarehouseProductStockLogsPartial && !$this->isNew();
        if (null === $this->collWarehouseProductStockLogs || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collWarehouseProductStockLogs) {
                    $this->initWarehouseProductStockLogs();
                } else {
                    $collectionClassName = WarehouseProductStockLogTableMap::getTableMap()->getCollectionClassName();

                    $collWarehouseProductStockLogs = new $collectionClassName;
                    $collWarehouseProductStockLogs->setModel('\DbModel\WarehouseProductStockLog');

                    return $collWarehouseProductStockLogs;
                }
            } else {
                $collWarehouseProductStockLogs = ChildWarehouseProductStockLogQuery::create(null, $criteria)
                    ->filterByProducts($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collWarehouseProductStockLogsPartial && count($collWarehouseProductStockLogs)) {
                        $this->initWarehouseProductStockLogs(false);

                        foreach ($collWarehouseProductStockLogs as $obj) {
                            if (false == $this->collWarehouseProductStockLogs->contains($obj)) {
                                $this->collWarehouseProductStockLogs->append($obj);
                            }
                        }

                        $this->collWarehouseProductStockLogsPartial = true;
                    }

                    return $collWarehouseProductStockLogs;
                }

                if ($partial && $this->collWarehouseProductStockLogs) {
                    foreach ($this->collWarehouseProductStockLogs as $obj) {
                        if ($obj->isNew()) {
                            $collWarehouseProductStockLogs[] = $obj;
                        }
                    }
                }

                $this->collWarehouseProductStockLogs = $collWarehouseProductStockLogs;
                $this->collWarehouseProductStockLogsPartial = false;
            }
        }

        return $this->collWarehouseProductStockLogs;
    }

    /**
     * Sets a collection of ChildWarehouseProductStockLog objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $warehouseProductStockLogs A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setWarehouseProductStockLogs(Collection $warehouseProductStockLogs, ?ConnectionInterface $con = null)
    {
        /** @var ChildWarehouseProductStockLog[] $warehouseProductStockLogsToDelete */
        $warehouseProductStockLogsToDelete = $this->getWarehouseProductStockLogs(new Criteria(), $con)->diff($warehouseProductStockLogs);


        $this->warehouseProductStockLogsScheduledForDeletion = $warehouseProductStockLogsToDelete;

        foreach ($warehouseProductStockLogsToDelete as $warehouseProductStockLogRemoved) {
            $warehouseProductStockLogRemoved->setProducts(null);
        }

        $this->collWarehouseProductStockLogs = null;
        foreach ($warehouseProductStockLogs as $warehouseProductStockLog) {
            $this->addWarehouseProductStockLog($warehouseProductStockLog);
        }

        $this->collWarehouseProductStockLogs = $warehouseProductStockLogs;
        $this->collWarehouseProductStockLogsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related WarehouseProductStockLog objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related WarehouseProductStockLog objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countWarehouseProductStockLogs(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collWarehouseProductStockLogsPartial && !$this->isNew();
        if (null === $this->collWarehouseProductStockLogs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collWarehouseProductStockLogs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getWarehouseProductStockLogs());
            }

            $query = ChildWarehouseProductStockLogQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProducts($this)
                ->count($con);
        }

        return count($this->collWarehouseProductStockLogs);
    }

    /**
     * Method called to associate a ChildWarehouseProductStockLog object to this object
     * through the ChildWarehouseProductStockLog foreign key attribute.
     *
     * @param ChildWarehouseProductStockLog $l ChildWarehouseProductStockLog
     * @return $this The current object (for fluent API support)
     */
    public function addWarehouseProductStockLog(ChildWarehouseProductStockLog $l)
    {
        if ($this->collWarehouseProductStockLogs === null) {
            $this->initWarehouseProductStockLogs();
            $this->collWarehouseProductStockLogsPartial = true;
        }

        if (!$this->collWarehouseProductStockLogs->contains($l)) {
            $this->doAddWarehouseProductStockLog($l);

            if ($this->warehouseProductStockLogsScheduledForDeletion and $this->warehouseProductStockLogsScheduledForDeletion->contains($l)) {
                $this->warehouseProductStockLogsScheduledForDeletion->remove($this->warehouseProductStockLogsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildWarehouseProductStockLog $warehouseProductStockLog The ChildWarehouseProductStockLog object to add.
     */
    protected function doAddWarehouseProductStockLog(ChildWarehouseProductStockLog $warehouseProductStockLog): void
    {
        $this->collWarehouseProductStockLogs[]= $warehouseProductStockLog;
        $warehouseProductStockLog->setProducts($this);
    }

    /**
     * @param ChildWarehouseProductStockLog $warehouseProductStockLog The ChildWarehouseProductStockLog object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeWarehouseProductStockLog(ChildWarehouseProductStockLog $warehouseProductStockLog)
    {
        if ($this->getWarehouseProductStockLogs()->contains($warehouseProductStockLog)) {
            $pos = $this->collWarehouseProductStockLogs->search($warehouseProductStockLog);
            $this->collWarehouseProductStockLogs->remove($pos);
            if (null === $this->warehouseProductStockLogsScheduledForDeletion) {
                $this->warehouseProductStockLogsScheduledForDeletion = clone $this->collWarehouseProductStockLogs;
                $this->warehouseProductStockLogsScheduledForDeletion->clear();
            }
            $this->warehouseProductStockLogsScheduledForDeletion[]= clone $warehouseProductStockLog;
            $warehouseProductStockLog->setProducts(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Products is new, it will return
     * an empty collection; or if this Products has previously
     * been saved, it will retrieve related WarehouseProductStockLogs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Products.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildWarehouseProductStockLog[] List of ChildWarehouseProductStockLog objects
     * @phpstan-return ObjectCollection&\Traversable<ChildWarehouseProductStockLog}> List of ChildWarehouseProductStockLog objects
     */
    public function getWarehouseProductStockLogsJoinWarehouses(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildWarehouseProductStockLogQuery::create(null, $criteria);
        $query->joinWith('Warehouses', $joinBehavior);

        return $this->getWarehouseProductStockLogs($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     *
     * @return $this
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->created_on = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);

        return $this;
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param bool $deep Whether to also clear the references on all referrer objects.
     * @return $this
     */
    public function clearAllReferences(bool $deep = false)
    {
        if ($deep) {
            if ($this->collStockTransactionss) {
                foreach ($this->collStockTransactionss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collWarehouseProductStocks) {
                foreach ($this->collWarehouseProductStocks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collWarehouseProductStockLogs) {
                foreach ($this->collWarehouseProductStockLogs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collStockTransactionss = null;
        $this->collWarehouseProductStocks = null;
        $this->collWarehouseProductStockLogs = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProductsTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preSave(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postSave(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before inserting to database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preInsert(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postInsert(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preUpdate(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postUpdate(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preDelete(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postDelete(?ConnectionInterface $con = null): void
    {
            }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);
            $inputData = $params[0];
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->importFrom($format, $inputData, $keyType);
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = $params[0] ?? true;
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->exportTo($format, $includeLazyLoadColumns, $keyType);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
