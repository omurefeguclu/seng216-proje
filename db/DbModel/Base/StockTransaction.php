<?php

namespace DbModel\Base;

use \DateTime;
use \Exception;
use \PDO;
use DbModel\Product as ChildProduct;
use DbModel\ProductQuery as ChildProductQuery;
use DbModel\StockTransaction as ChildStockTransaction;
use DbModel\StockTransactionQuery as ChildStockTransactionQuery;
use DbModel\User as ChildUser;
use DbModel\UserQuery as ChildUserQuery;
use DbModel\Vehicle as ChildVehicle;
use DbModel\VehicleQuery as ChildVehicleQuery;
use DbModel\Warehouse as ChildWarehouse;
use DbModel\WarehouseProductStockLog as ChildWarehouseProductStockLog;
use DbModel\WarehouseProductStockLogQuery as ChildWarehouseProductStockLogQuery;
use DbModel\WarehouseQuery as ChildWarehouseQuery;
use DbModel\Map\StockTransactionTableMap;
use DbModel\Map\WarehouseProductStockLogTableMap;
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
 * Base class that represents a row from the 'stock_transactions' table.
 *
 *
 *
 * @package    propel.generator.DbModel.Base
 */
abstract class StockTransaction implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\DbModel\\Map\\StockTransactionTableMap';


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
     * The value for the product_id field.
     *
     * @var        int
     */
    protected $product_id;

    /**
     * The value for the from_warehouse_id field.
     *
     * @var        int|null
     */
    protected $from_warehouse_id;

    /**
     * The value for the to_warehouse_id field.
     *
     * @var        int|null
     */
    protected $to_warehouse_id;

    /**
     * The value for the vehicle_id field.
     *
     * @var        int|null
     */
    protected $vehicle_id;

    /**
     * The value for the creator_user_id field.
     *
     * @var        int|null
     */
    protected $creator_user_id;

    /**
     * The value for the amount field.
     *
     * @var        int
     */
    protected $amount;

    /**
     * The value for the created_on field.
     *
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        DateTime
     */
    protected $created_on;

    /**
     * @var        ChildProduct
     */
    protected $aProduct;

    /**
     * @var        ChildWarehouse
     */
    protected $aWarehouseRelatedByFromWarehouseId;

    /**
     * @var        ChildWarehouse
     */
    protected $aWarehouseRelatedByToWarehouseId;

    /**
     * @var        ChildVehicle
     */
    protected $aVehicle;

    /**
     * @var        ChildUser
     */
    protected $aUser;

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
     * Initializes internal state of DbModel\Base\StockTransaction object.
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
     * Compares this with another <code>StockTransaction</code> instance.  If
     * <code>obj</code> is an instance of <code>StockTransaction</code>, delegates to
     * <code>equals(StockTransaction)</code>.  Otherwise, returns <code>false</code>.
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
     * Get the [product_id] column value.
     *
     * @return int
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * Get the [from_warehouse_id] column value.
     *
     * @return int|null
     */
    public function getFromWarehouseId()
    {
        return $this->from_warehouse_id;
    }

    /**
     * Get the [to_warehouse_id] column value.
     *
     * @return int|null
     */
    public function getToWarehouseId()
    {
        return $this->to_warehouse_id;
    }

    /**
     * Get the [vehicle_id] column value.
     *
     * @return int|null
     */
    public function getVehicleId()
    {
        return $this->vehicle_id;
    }

    /**
     * Get the [creator_user_id] column value.
     *
     * @return int|null
     */
    public function getCreatorUserId()
    {
        return $this->creator_user_id;
    }

    /**
     * Get the [amount] column value.
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
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
            $this->modifiedColumns[StockTransactionTableMap::COL_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [product_id] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setProductId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->product_id !== $v) {
            $this->product_id = $v;
            $this->modifiedColumns[StockTransactionTableMap::COL_PRODUCT_ID] = true;
        }

        if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
            $this->aProduct = null;
        }

        return $this;
    }

    /**
     * Set the value of [from_warehouse_id] column.
     *
     * @param int|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setFromWarehouseId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->from_warehouse_id !== $v) {
            $this->from_warehouse_id = $v;
            $this->modifiedColumns[StockTransactionTableMap::COL_FROM_WAREHOUSE_ID] = true;
        }

        if ($this->aWarehouseRelatedByFromWarehouseId !== null && $this->aWarehouseRelatedByFromWarehouseId->getId() !== $v) {
            $this->aWarehouseRelatedByFromWarehouseId = null;
        }

        return $this;
    }

    /**
     * Set the value of [to_warehouse_id] column.
     *
     * @param int|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setToWarehouseId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->to_warehouse_id !== $v) {
            $this->to_warehouse_id = $v;
            $this->modifiedColumns[StockTransactionTableMap::COL_TO_WAREHOUSE_ID] = true;
        }

        if ($this->aWarehouseRelatedByToWarehouseId !== null && $this->aWarehouseRelatedByToWarehouseId->getId() !== $v) {
            $this->aWarehouseRelatedByToWarehouseId = null;
        }

        return $this;
    }

    /**
     * Set the value of [vehicle_id] column.
     *
     * @param int|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setVehicleId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->vehicle_id !== $v) {
            $this->vehicle_id = $v;
            $this->modifiedColumns[StockTransactionTableMap::COL_VEHICLE_ID] = true;
        }

        if ($this->aVehicle !== null && $this->aVehicle->getId() !== $v) {
            $this->aVehicle = null;
        }

        return $this;
    }

    /**
     * Set the value of [creator_user_id] column.
     *
     * @param int|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setCreatorUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->creator_user_id !== $v) {
            $this->creator_user_id = $v;
            $this->modifiedColumns[StockTransactionTableMap::COL_CREATOR_USER_ID] = true;
        }

        if ($this->aUser !== null && $this->aUser->getId() !== $v) {
            $this->aUser = null;
        }

        return $this;
    }

    /**
     * Set the value of [amount] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setAmount($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->amount !== $v) {
            $this->amount = $v;
            $this->modifiedColumns[StockTransactionTableMap::COL_AMOUNT] = true;
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
                $this->modifiedColumns[StockTransactionTableMap::COL_CREATED_ON] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : StockTransactionTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : StockTransactionTableMap::translateFieldName('ProductId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->product_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : StockTransactionTableMap::translateFieldName('FromWarehouseId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->from_warehouse_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : StockTransactionTableMap::translateFieldName('ToWarehouseId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->to_warehouse_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : StockTransactionTableMap::translateFieldName('VehicleId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->vehicle_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : StockTransactionTableMap::translateFieldName('CreatorUserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->creator_user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : StockTransactionTableMap::translateFieldName('Amount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->amount = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : StockTransactionTableMap::translateFieldName('CreatedOn', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_on = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = StockTransactionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\DbModel\\StockTransaction'), 0, $e);
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
        if ($this->aProduct !== null && $this->product_id !== $this->aProduct->getId()) {
            $this->aProduct = null;
        }
        if ($this->aWarehouseRelatedByFromWarehouseId !== null && $this->from_warehouse_id !== $this->aWarehouseRelatedByFromWarehouseId->getId()) {
            $this->aWarehouseRelatedByFromWarehouseId = null;
        }
        if ($this->aWarehouseRelatedByToWarehouseId !== null && $this->to_warehouse_id !== $this->aWarehouseRelatedByToWarehouseId->getId()) {
            $this->aWarehouseRelatedByToWarehouseId = null;
        }
        if ($this->aVehicle !== null && $this->vehicle_id !== $this->aVehicle->getId()) {
            $this->aVehicle = null;
        }
        if ($this->aUser !== null && $this->creator_user_id !== $this->aUser->getId()) {
            $this->aUser = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(StockTransactionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildStockTransactionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aProduct = null;
            $this->aWarehouseRelatedByFromWarehouseId = null;
            $this->aWarehouseRelatedByToWarehouseId = null;
            $this->aVehicle = null;
            $this->aUser = null;
            $this->collWarehouseProductStockLogs = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see StockTransaction::setDeleted()
     * @see StockTransaction::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockTransactionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildStockTransactionQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(StockTransactionTableMap::DATABASE_NAME);
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
                StockTransactionTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aProduct !== null) {
                if ($this->aProduct->isModified() || $this->aProduct->isNew()) {
                    $affectedRows += $this->aProduct->save($con);
                }
                $this->setProduct($this->aProduct);
            }

            if ($this->aWarehouseRelatedByFromWarehouseId !== null) {
                if ($this->aWarehouseRelatedByFromWarehouseId->isModified() || $this->aWarehouseRelatedByFromWarehouseId->isNew()) {
                    $affectedRows += $this->aWarehouseRelatedByFromWarehouseId->save($con);
                }
                $this->setWarehouseRelatedByFromWarehouseId($this->aWarehouseRelatedByFromWarehouseId);
            }

            if ($this->aWarehouseRelatedByToWarehouseId !== null) {
                if ($this->aWarehouseRelatedByToWarehouseId->isModified() || $this->aWarehouseRelatedByToWarehouseId->isNew()) {
                    $affectedRows += $this->aWarehouseRelatedByToWarehouseId->save($con);
                }
                $this->setWarehouseRelatedByToWarehouseId($this->aWarehouseRelatedByToWarehouseId);
            }

            if ($this->aVehicle !== null) {
                if ($this->aVehicle->isModified() || $this->aVehicle->isNew()) {
                    $affectedRows += $this->aVehicle->save($con);
                }
                $this->setVehicle($this->aVehicle);
            }

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

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

            if ($this->warehouseProductStockLogsScheduledForDeletion !== null) {
                if (!$this->warehouseProductStockLogsScheduledForDeletion->isEmpty()) {
                    foreach ($this->warehouseProductStockLogsScheduledForDeletion as $warehouseProductStockLog) {
                        // need to save related object because we set the relation to null
                        $warehouseProductStockLog->save($con);
                    }
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

        $this->modifiedColumns[StockTransactionTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . StockTransactionTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(StockTransactionTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(StockTransactionTableMap::COL_PRODUCT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'product_id';
        }
        if ($this->isColumnModified(StockTransactionTableMap::COL_FROM_WAREHOUSE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'from_warehouse_id';
        }
        if ($this->isColumnModified(StockTransactionTableMap::COL_TO_WAREHOUSE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'to_warehouse_id';
        }
        if ($this->isColumnModified(StockTransactionTableMap::COL_VEHICLE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'vehicle_id';
        }
        if ($this->isColumnModified(StockTransactionTableMap::COL_CREATOR_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'creator_user_id';
        }
        if ($this->isColumnModified(StockTransactionTableMap::COL_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'amount';
        }
        if ($this->isColumnModified(StockTransactionTableMap::COL_CREATED_ON)) {
            $modifiedColumns[':p' . $index++]  = 'created_on';
        }

        $sql = sprintf(
            'INSERT INTO stock_transactions (%s) VALUES (%s)',
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
                    case 'product_id':
                        $stmt->bindValue($identifier, $this->product_id, PDO::PARAM_INT);

                        break;
                    case 'from_warehouse_id':
                        $stmt->bindValue($identifier, $this->from_warehouse_id, PDO::PARAM_INT);

                        break;
                    case 'to_warehouse_id':
                        $stmt->bindValue($identifier, $this->to_warehouse_id, PDO::PARAM_INT);

                        break;
                    case 'vehicle_id':
                        $stmt->bindValue($identifier, $this->vehicle_id, PDO::PARAM_INT);

                        break;
                    case 'creator_user_id':
                        $stmt->bindValue($identifier, $this->creator_user_id, PDO::PARAM_INT);

                        break;
                    case 'amount':
                        $stmt->bindValue($identifier, $this->amount, PDO::PARAM_INT);

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
        $pos = StockTransactionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getProductId();

            case 2:
                return $this->getFromWarehouseId();

            case 3:
                return $this->getToWarehouseId();

            case 4:
                return $this->getVehicleId();

            case 5:
                return $this->getCreatorUserId();

            case 6:
                return $this->getAmount();

            case 7:
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
        if (isset($alreadyDumpedObjects['StockTransaction'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['StockTransaction'][$this->hashCode()] = true;
        $keys = StockTransactionTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getProductId(),
            $keys[2] => $this->getFromWarehouseId(),
            $keys[3] => $this->getToWarehouseId(),
            $keys[4] => $this->getVehicleId(),
            $keys[5] => $this->getCreatorUserId(),
            $keys[6] => $this->getAmount(),
            $keys[7] => $this->getCreatedOn(),
        ];
        if ($result[$keys[7]] instanceof \DateTimeInterface) {
            $result[$keys[7]] = $result[$keys[7]]->format('Y-m-d H:i:s.u');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aProduct) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'product';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'products';
                        break;
                    default:
                        $key = 'Product';
                }

                $result[$key] = $this->aProduct->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aWarehouseRelatedByFromWarehouseId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'warehouse';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'warehouses';
                        break;
                    default:
                        $key = 'Warehouse';
                }

                $result[$key] = $this->aWarehouseRelatedByFromWarehouseId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aWarehouseRelatedByToWarehouseId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'warehouse';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'warehouses';
                        break;
                    default:
                        $key = 'Warehouse';
                }

                $result[$key] = $this->aWarehouseRelatedByToWarehouseId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aVehicle) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'vehicle';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'vehicles';
                        break;
                    default:
                        $key = 'Vehicle';
                }

                $result[$key] = $this->aVehicle->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUser) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'users';
                        break;
                    default:
                        $key = 'User';
                }

                $result[$key] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = StockTransactionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setProductId($value);
                break;
            case 2:
                $this->setFromWarehouseId($value);
                break;
            case 3:
                $this->setToWarehouseId($value);
                break;
            case 4:
                $this->setVehicleId($value);
                break;
            case 5:
                $this->setCreatorUserId($value);
                break;
            case 6:
                $this->setAmount($value);
                break;
            case 7:
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
        $keys = StockTransactionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setProductId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setFromWarehouseId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setToWarehouseId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setVehicleId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCreatorUserId($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setAmount($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setCreatedOn($arr[$keys[7]]);
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
        $criteria = new Criteria(StockTransactionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(StockTransactionTableMap::COL_ID)) {
            $criteria->add(StockTransactionTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(StockTransactionTableMap::COL_PRODUCT_ID)) {
            $criteria->add(StockTransactionTableMap::COL_PRODUCT_ID, $this->product_id);
        }
        if ($this->isColumnModified(StockTransactionTableMap::COL_FROM_WAREHOUSE_ID)) {
            $criteria->add(StockTransactionTableMap::COL_FROM_WAREHOUSE_ID, $this->from_warehouse_id);
        }
        if ($this->isColumnModified(StockTransactionTableMap::COL_TO_WAREHOUSE_ID)) {
            $criteria->add(StockTransactionTableMap::COL_TO_WAREHOUSE_ID, $this->to_warehouse_id);
        }
        if ($this->isColumnModified(StockTransactionTableMap::COL_VEHICLE_ID)) {
            $criteria->add(StockTransactionTableMap::COL_VEHICLE_ID, $this->vehicle_id);
        }
        if ($this->isColumnModified(StockTransactionTableMap::COL_CREATOR_USER_ID)) {
            $criteria->add(StockTransactionTableMap::COL_CREATOR_USER_ID, $this->creator_user_id);
        }
        if ($this->isColumnModified(StockTransactionTableMap::COL_AMOUNT)) {
            $criteria->add(StockTransactionTableMap::COL_AMOUNT, $this->amount);
        }
        if ($this->isColumnModified(StockTransactionTableMap::COL_CREATED_ON)) {
            $criteria->add(StockTransactionTableMap::COL_CREATED_ON, $this->created_on);
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
        $criteria = ChildStockTransactionQuery::create();
        $criteria->add(StockTransactionTableMap::COL_ID, $this->id);

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
     * @param object $copyObj An object of \DbModel\StockTransaction (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setProductId($this->getProductId());
        $copyObj->setFromWarehouseId($this->getFromWarehouseId());
        $copyObj->setToWarehouseId($this->getToWarehouseId());
        $copyObj->setVehicleId($this->getVehicleId());
        $copyObj->setCreatorUserId($this->getCreatorUserId());
        $copyObj->setAmount($this->getAmount());
        $copyObj->setCreatedOn($this->getCreatedOn());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

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
     * @return \DbModel\StockTransaction Clone of current object.
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
     * Declares an association between this object and a ChildProduct object.
     *
     * @param ChildProduct $v
     * @return $this The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setProduct(ChildProduct $v = null)
    {
        if ($v === null) {
            $this->setProductId(NULL);
        } else {
            $this->setProductId($v->getId());
        }

        $this->aProduct = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildProduct object, it will not be re-added.
        if ($v !== null) {
            $v->addStockTransaction($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildProduct object
     *
     * @param ConnectionInterface $con Optional Connection object.
     * @return ChildProduct The associated ChildProduct object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getProduct(?ConnectionInterface $con = null)
    {
        if ($this->aProduct === null && ($this->product_id != 0)) {
            $this->aProduct = ChildProductQuery::create()->findPk($this->product_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProduct->addStockTransactions($this);
             */
        }

        return $this->aProduct;
    }

    /**
     * Declares an association between this object and a ChildWarehouse object.
     *
     * @param ChildWarehouse|null $v
     * @return $this The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setWarehouseRelatedByFromWarehouseId(ChildWarehouse $v = null)
    {
        if ($v === null) {
            $this->setFromWarehouseId(NULL);
        } else {
            $this->setFromWarehouseId($v->getId());
        }

        $this->aWarehouseRelatedByFromWarehouseId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildWarehouse object, it will not be re-added.
        if ($v !== null) {
            $v->addStockTransactionRelatedByFromWarehouseId($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildWarehouse object
     *
     * @param ConnectionInterface $con Optional Connection object.
     * @return ChildWarehouse|null The associated ChildWarehouse object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getWarehouseRelatedByFromWarehouseId(?ConnectionInterface $con = null)
    {
        if ($this->aWarehouseRelatedByFromWarehouseId === null && ($this->from_warehouse_id != 0)) {
            $this->aWarehouseRelatedByFromWarehouseId = ChildWarehouseQuery::create()->findPk($this->from_warehouse_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aWarehouseRelatedByFromWarehouseId->addStockTransactionsRelatedByFromWarehouseId($this);
             */
        }

        return $this->aWarehouseRelatedByFromWarehouseId;
    }

    /**
     * Declares an association between this object and a ChildWarehouse object.
     *
     * @param ChildWarehouse|null $v
     * @return $this The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setWarehouseRelatedByToWarehouseId(ChildWarehouse $v = null)
    {
        if ($v === null) {
            $this->setToWarehouseId(NULL);
        } else {
            $this->setToWarehouseId($v->getId());
        }

        $this->aWarehouseRelatedByToWarehouseId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildWarehouse object, it will not be re-added.
        if ($v !== null) {
            $v->addStockTransactionRelatedByToWarehouseId($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildWarehouse object
     *
     * @param ConnectionInterface $con Optional Connection object.
     * @return ChildWarehouse|null The associated ChildWarehouse object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getWarehouseRelatedByToWarehouseId(?ConnectionInterface $con = null)
    {
        if ($this->aWarehouseRelatedByToWarehouseId === null && ($this->to_warehouse_id != 0)) {
            $this->aWarehouseRelatedByToWarehouseId = ChildWarehouseQuery::create()->findPk($this->to_warehouse_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aWarehouseRelatedByToWarehouseId->addStockTransactionsRelatedByToWarehouseId($this);
             */
        }

        return $this->aWarehouseRelatedByToWarehouseId;
    }

    /**
     * Declares an association between this object and a ChildVehicle object.
     *
     * @param ChildVehicle|null $v
     * @return $this The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setVehicle(ChildVehicle $v = null)
    {
        if ($v === null) {
            $this->setVehicleId(NULL);
        } else {
            $this->setVehicleId($v->getId());
        }

        $this->aVehicle = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildVehicle object, it will not be re-added.
        if ($v !== null) {
            $v->addStockTransaction($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildVehicle object
     *
     * @param ConnectionInterface $con Optional Connection object.
     * @return ChildVehicle|null The associated ChildVehicle object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getVehicle(?ConnectionInterface $con = null)
    {
        if ($this->aVehicle === null && ($this->vehicle_id != 0)) {
            $this->aVehicle = ChildVehicleQuery::create()->findPk($this->vehicle_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aVehicle->addStockTransactions($this);
             */
        }

        return $this->aVehicle;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param ChildUser|null $v
     * @return $this The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setCreatorUserId(NULL);
        } else {
            $this->setCreatorUserId($v->getId());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addStockTransaction($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param ConnectionInterface $con Optional Connection object.
     * @return ChildUser|null The associated ChildUser object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getUser(?ConnectionInterface $con = null)
    {
        if ($this->aUser === null && ($this->creator_user_id != 0)) {
            $this->aUser = ChildUserQuery::create()->findPk($this->creator_user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addStockTransactions($this);
             */
        }

        return $this->aUser;
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
        if ('WarehouseProductStockLog' === $relationName) {
            $this->initWarehouseProductStockLogs();
            return;
        }
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
     * If this ChildStockTransaction is new, it will return
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
                    ->filterByStockTransaction($this)
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
            $warehouseProductStockLogRemoved->setStockTransaction(null);
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
                ->filterByStockTransaction($this)
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
        $warehouseProductStockLog->setStockTransaction($this);
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
            $this->warehouseProductStockLogsScheduledForDeletion[]= $warehouseProductStockLog;
            $warehouseProductStockLog->setStockTransaction(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this StockTransaction is new, it will return
     * an empty collection; or if this StockTransaction has previously
     * been saved, it will retrieve related WarehouseProductStockLogs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in StockTransaction.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildWarehouseProductStockLog[] List of ChildWarehouseProductStockLog objects
     * @phpstan-return ObjectCollection&\Traversable<ChildWarehouseProductStockLog}> List of ChildWarehouseProductStockLog objects
     */
    public function getWarehouseProductStockLogsJoinWarehouse(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildWarehouseProductStockLogQuery::create(null, $criteria);
        $query->joinWith('Warehouse', $joinBehavior);

        return $this->getWarehouseProductStockLogs($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this StockTransaction is new, it will return
     * an empty collection; or if this StockTransaction has previously
     * been saved, it will retrieve related WarehouseProductStockLogs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in StockTransaction.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildWarehouseProductStockLog[] List of ChildWarehouseProductStockLog objects
     * @phpstan-return ObjectCollection&\Traversable<ChildWarehouseProductStockLog}> List of ChildWarehouseProductStockLog objects
     */
    public function getWarehouseProductStockLogsJoinProduct(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildWarehouseProductStockLogQuery::create(null, $criteria);
        $query->joinWith('Product', $joinBehavior);

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
        if (null !== $this->aProduct) {
            $this->aProduct->removeStockTransaction($this);
        }
        if (null !== $this->aWarehouseRelatedByFromWarehouseId) {
            $this->aWarehouseRelatedByFromWarehouseId->removeStockTransactionRelatedByFromWarehouseId($this);
        }
        if (null !== $this->aWarehouseRelatedByToWarehouseId) {
            $this->aWarehouseRelatedByToWarehouseId->removeStockTransactionRelatedByToWarehouseId($this);
        }
        if (null !== $this->aVehicle) {
            $this->aVehicle->removeStockTransaction($this);
        }
        if (null !== $this->aUser) {
            $this->aUser->removeStockTransaction($this);
        }
        $this->id = null;
        $this->product_id = null;
        $this->from_warehouse_id = null;
        $this->to_warehouse_id = null;
        $this->vehicle_id = null;
        $this->creator_user_id = null;
        $this->amount = null;
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
            if ($this->collWarehouseProductStockLogs) {
                foreach ($this->collWarehouseProductStockLogs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collWarehouseProductStockLogs = null;
        $this->aProduct = null;
        $this->aWarehouseRelatedByFromWarehouseId = null;
        $this->aWarehouseRelatedByToWarehouseId = null;
        $this->aVehicle = null;
        $this->aUser = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(StockTransactionTableMap::DEFAULT_STRING_FORMAT);
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
