<?php

namespace DbModel\Base;

use \DateTime;
use \Exception;
use \PDO;
use DbModel\StockTransaction as ChildStockTransaction;
use DbModel\StockTransactionQuery as ChildStockTransactionQuery;
use DbModel\Warehouse as ChildWarehouse;
use DbModel\WarehouseProductStockLog as ChildWarehouseProductStockLog;
use DbModel\WarehouseProductStockLogQuery as ChildWarehouseProductStockLogQuery;
use DbModel\WarehouseQuery as ChildWarehouseQuery;
use DbModel\Map\StockTransactionTableMap;
use DbModel\Map\WarehouseProductStockLogTableMap;
use DbModel\Map\WarehouseTableMap;
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
 * Base class that represents a row from the 'warehouses' table.
 *
 *
 *
 * @package    propel.generator.DbModel.Base
 */
abstract class Warehouse implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\DbModel\\Map\\WarehouseTableMap';


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
     * @var        ObjectCollection|ChildStockTransaction[] Collection to store aggregation of ChildStockTransaction objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildStockTransaction> Collection to store aggregation of ChildStockTransaction objects.
     */
    protected $collStockTransactionsRelatedByFromWarehouseId;
    protected $collStockTransactionsRelatedByFromWarehouseIdPartial;

    /**
     * @var        ObjectCollection|ChildStockTransaction[] Collection to store aggregation of ChildStockTransaction objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildStockTransaction> Collection to store aggregation of ChildStockTransaction objects.
     */
    protected $collStockTransactionsRelatedByToWarehouseId;
    protected $collStockTransactionsRelatedByToWarehouseIdPartial;

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
     * @var ObjectCollection|ChildStockTransaction[]
     * @phpstan-var ObjectCollection&\Traversable<ChildStockTransaction>
     */
    protected $stockTransactionsRelatedByFromWarehouseIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStockTransaction[]
     * @phpstan-var ObjectCollection&\Traversable<ChildStockTransaction>
     */
    protected $stockTransactionsRelatedByToWarehouseIdScheduledForDeletion = null;

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
     * Initializes internal state of DbModel\Base\Warehouse object.
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
     * Compares this with another <code>Warehouse</code> instance.  If
     * <code>obj</code> is an instance of <code>Warehouse</code>, delegates to
     * <code>equals(Warehouse)</code>.  Otherwise, returns <code>false</code>.
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
            $this->modifiedColumns[WarehouseTableMap::COL_ID] = true;
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
            $this->modifiedColumns[WarehouseTableMap::COL_NAME] = true;
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
                $this->modifiedColumns[WarehouseTableMap::COL_CREATED_ON] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : WarehouseTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : WarehouseTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : WarehouseTableMap::translateFieldName('CreatedOn', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_on = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = WarehouseTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\DbModel\\Warehouse'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(WarehouseTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildWarehouseQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collStockTransactionsRelatedByFromWarehouseId = null;

            $this->collStockTransactionsRelatedByToWarehouseId = null;

            $this->collWarehouseProductStockLogs = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see Warehouse::setDeleted()
     * @see Warehouse::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(WarehouseTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildWarehouseQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(WarehouseTableMap::DATABASE_NAME);
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
                WarehouseTableMap::addInstanceToPool($this);
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

            if ($this->stockTransactionsRelatedByFromWarehouseIdScheduledForDeletion !== null) {
                if (!$this->stockTransactionsRelatedByFromWarehouseIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->stockTransactionsRelatedByFromWarehouseIdScheduledForDeletion as $stockTransactionRelatedByFromWarehouseId) {
                        // need to save related object because we set the relation to null
                        $stockTransactionRelatedByFromWarehouseId->save($con);
                    }
                    $this->stockTransactionsRelatedByFromWarehouseIdScheduledForDeletion = null;
                }
            }

            if ($this->collStockTransactionsRelatedByFromWarehouseId !== null) {
                foreach ($this->collStockTransactionsRelatedByFromWarehouseId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->stockTransactionsRelatedByToWarehouseIdScheduledForDeletion !== null) {
                if (!$this->stockTransactionsRelatedByToWarehouseIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->stockTransactionsRelatedByToWarehouseIdScheduledForDeletion as $stockTransactionRelatedByToWarehouseId) {
                        // need to save related object because we set the relation to null
                        $stockTransactionRelatedByToWarehouseId->save($con);
                    }
                    $this->stockTransactionsRelatedByToWarehouseIdScheduledForDeletion = null;
                }
            }

            if ($this->collStockTransactionsRelatedByToWarehouseId !== null) {
                foreach ($this->collStockTransactionsRelatedByToWarehouseId as $referrerFK) {
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

        $this->modifiedColumns[WarehouseTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . WarehouseTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(WarehouseTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(WarehouseTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'NAME';
        }
        if ($this->isColumnModified(WarehouseTableMap::COL_CREATED_ON)) {
            $modifiedColumns[':p' . $index++]  = 'created_on';
        }

        $sql = sprintf(
            'INSERT INTO warehouses (%s) VALUES (%s)',
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
        $pos = WarehouseTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
        if (isset($alreadyDumpedObjects['Warehouse'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Warehouse'][$this->hashCode()] = true;
        $keys = WarehouseTableMap::getFieldNames($keyType);
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
            if (null !== $this->collStockTransactionsRelatedByFromWarehouseId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'stockTransactions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'stock_transactionss';
                        break;
                    default:
                        $key = 'StockTransactions';
                }

                $result[$key] = $this->collStockTransactionsRelatedByFromWarehouseId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStockTransactionsRelatedByToWarehouseId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'stockTransactions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'stock_transactionss';
                        break;
                    default:
                        $key = 'StockTransactions';
                }

                $result[$key] = $this->collStockTransactionsRelatedByToWarehouseId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = WarehouseTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
        $keys = WarehouseTableMap::getFieldNames($keyType);

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
        $criteria = new Criteria(WarehouseTableMap::DATABASE_NAME);

        if ($this->isColumnModified(WarehouseTableMap::COL_ID)) {
            $criteria->add(WarehouseTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(WarehouseTableMap::COL_NAME)) {
            $criteria->add(WarehouseTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(WarehouseTableMap::COL_CREATED_ON)) {
            $criteria->add(WarehouseTableMap::COL_CREATED_ON, $this->created_on);
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
        $criteria = ChildWarehouseQuery::create();
        $criteria->add(WarehouseTableMap::COL_ID, $this->id);

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
     * @param object $copyObj An object of \DbModel\Warehouse (or compatible) type.
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

            foreach ($this->getStockTransactionsRelatedByFromWarehouseId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStockTransactionRelatedByFromWarehouseId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStockTransactionsRelatedByToWarehouseId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStockTransactionRelatedByToWarehouseId($relObj->copy($deepCopy));
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
     * @return \DbModel\Warehouse Clone of current object.
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
        if ('StockTransactionRelatedByFromWarehouseId' === $relationName) {
            $this->initStockTransactionsRelatedByFromWarehouseId();
            return;
        }
        if ('StockTransactionRelatedByToWarehouseId' === $relationName) {
            $this->initStockTransactionsRelatedByToWarehouseId();
            return;
        }
        if ('WarehouseProductStockLog' === $relationName) {
            $this->initWarehouseProductStockLogs();
            return;
        }
    }

    /**
     * Clears out the collStockTransactionsRelatedByFromWarehouseId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addStockTransactionsRelatedByFromWarehouseId()
     */
    public function clearStockTransactionsRelatedByFromWarehouseId()
    {
        $this->collStockTransactionsRelatedByFromWarehouseId = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collStockTransactionsRelatedByFromWarehouseId collection loaded partially.
     *
     * @return void
     */
    public function resetPartialStockTransactionsRelatedByFromWarehouseId($v = true): void
    {
        $this->collStockTransactionsRelatedByFromWarehouseIdPartial = $v;
    }

    /**
     * Initializes the collStockTransactionsRelatedByFromWarehouseId collection.
     *
     * By default this just sets the collStockTransactionsRelatedByFromWarehouseId collection to an empty array (like clearcollStockTransactionsRelatedByFromWarehouseId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStockTransactionsRelatedByFromWarehouseId(bool $overrideExisting = true): void
    {
        if (null !== $this->collStockTransactionsRelatedByFromWarehouseId && !$overrideExisting) {
            return;
        }

        $collectionClassName = StockTransactionTableMap::getTableMap()->getCollectionClassName();

        $this->collStockTransactionsRelatedByFromWarehouseId = new $collectionClassName;
        $this->collStockTransactionsRelatedByFromWarehouseId->setModel('\DbModel\StockTransaction');
    }

    /**
     * Gets an array of ChildStockTransaction objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildWarehouse is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStockTransaction[] List of ChildStockTransaction objects
     * @phpstan-return ObjectCollection&\Traversable<ChildStockTransaction> List of ChildStockTransaction objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getStockTransactionsRelatedByFromWarehouseId(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collStockTransactionsRelatedByFromWarehouseIdPartial && !$this->isNew();
        if (null === $this->collStockTransactionsRelatedByFromWarehouseId || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collStockTransactionsRelatedByFromWarehouseId) {
                    $this->initStockTransactionsRelatedByFromWarehouseId();
                } else {
                    $collectionClassName = StockTransactionTableMap::getTableMap()->getCollectionClassName();

                    $collStockTransactionsRelatedByFromWarehouseId = new $collectionClassName;
                    $collStockTransactionsRelatedByFromWarehouseId->setModel('\DbModel\StockTransaction');

                    return $collStockTransactionsRelatedByFromWarehouseId;
                }
            } else {
                $collStockTransactionsRelatedByFromWarehouseId = ChildStockTransactionQuery::create(null, $criteria)
                    ->filterByWarehouseRelatedByFromWarehouseId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStockTransactionsRelatedByFromWarehouseIdPartial && count($collStockTransactionsRelatedByFromWarehouseId)) {
                        $this->initStockTransactionsRelatedByFromWarehouseId(false);

                        foreach ($collStockTransactionsRelatedByFromWarehouseId as $obj) {
                            if (false == $this->collStockTransactionsRelatedByFromWarehouseId->contains($obj)) {
                                $this->collStockTransactionsRelatedByFromWarehouseId->append($obj);
                            }
                        }

                        $this->collStockTransactionsRelatedByFromWarehouseIdPartial = true;
                    }

                    return $collStockTransactionsRelatedByFromWarehouseId;
                }

                if ($partial && $this->collStockTransactionsRelatedByFromWarehouseId) {
                    foreach ($this->collStockTransactionsRelatedByFromWarehouseId as $obj) {
                        if ($obj->isNew()) {
                            $collStockTransactionsRelatedByFromWarehouseId[] = $obj;
                        }
                    }
                }

                $this->collStockTransactionsRelatedByFromWarehouseId = $collStockTransactionsRelatedByFromWarehouseId;
                $this->collStockTransactionsRelatedByFromWarehouseIdPartial = false;
            }
        }

        return $this->collStockTransactionsRelatedByFromWarehouseId;
    }

    /**
     * Sets a collection of ChildStockTransaction objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $stockTransactionsRelatedByFromWarehouseId A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setStockTransactionsRelatedByFromWarehouseId(Collection $stockTransactionsRelatedByFromWarehouseId, ?ConnectionInterface $con = null)
    {
        /** @var ChildStockTransaction[] $stockTransactionsRelatedByFromWarehouseIdToDelete */
        $stockTransactionsRelatedByFromWarehouseIdToDelete = $this->getStockTransactionsRelatedByFromWarehouseId(new Criteria(), $con)->diff($stockTransactionsRelatedByFromWarehouseId);


        $this->stockTransactionsRelatedByFromWarehouseIdScheduledForDeletion = $stockTransactionsRelatedByFromWarehouseIdToDelete;

        foreach ($stockTransactionsRelatedByFromWarehouseIdToDelete as $stockTransactionRelatedByFromWarehouseIdRemoved) {
            $stockTransactionRelatedByFromWarehouseIdRemoved->setWarehouseRelatedByFromWarehouseId(null);
        }

        $this->collStockTransactionsRelatedByFromWarehouseId = null;
        foreach ($stockTransactionsRelatedByFromWarehouseId as $stockTransactionRelatedByFromWarehouseId) {
            $this->addStockTransactionRelatedByFromWarehouseId($stockTransactionRelatedByFromWarehouseId);
        }

        $this->collStockTransactionsRelatedByFromWarehouseId = $stockTransactionsRelatedByFromWarehouseId;
        $this->collStockTransactionsRelatedByFromWarehouseIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related StockTransaction objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related StockTransaction objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countStockTransactionsRelatedByFromWarehouseId(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collStockTransactionsRelatedByFromWarehouseIdPartial && !$this->isNew();
        if (null === $this->collStockTransactionsRelatedByFromWarehouseId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStockTransactionsRelatedByFromWarehouseId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStockTransactionsRelatedByFromWarehouseId());
            }

            $query = ChildStockTransactionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByWarehouseRelatedByFromWarehouseId($this)
                ->count($con);
        }

        return count($this->collStockTransactionsRelatedByFromWarehouseId);
    }

    /**
     * Method called to associate a ChildStockTransaction object to this object
     * through the ChildStockTransaction foreign key attribute.
     *
     * @param ChildStockTransaction $l ChildStockTransaction
     * @return $this The current object (for fluent API support)
     */
    public function addStockTransactionRelatedByFromWarehouseId(ChildStockTransaction $l)
    {
        if ($this->collStockTransactionsRelatedByFromWarehouseId === null) {
            $this->initStockTransactionsRelatedByFromWarehouseId();
            $this->collStockTransactionsRelatedByFromWarehouseIdPartial = true;
        }

        if (!$this->collStockTransactionsRelatedByFromWarehouseId->contains($l)) {
            $this->doAddStockTransactionRelatedByFromWarehouseId($l);

            if ($this->stockTransactionsRelatedByFromWarehouseIdScheduledForDeletion and $this->stockTransactionsRelatedByFromWarehouseIdScheduledForDeletion->contains($l)) {
                $this->stockTransactionsRelatedByFromWarehouseIdScheduledForDeletion->remove($this->stockTransactionsRelatedByFromWarehouseIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildStockTransaction $stockTransactionRelatedByFromWarehouseId The ChildStockTransaction object to add.
     */
    protected function doAddStockTransactionRelatedByFromWarehouseId(ChildStockTransaction $stockTransactionRelatedByFromWarehouseId): void
    {
        $this->collStockTransactionsRelatedByFromWarehouseId[]= $stockTransactionRelatedByFromWarehouseId;
        $stockTransactionRelatedByFromWarehouseId->setWarehouseRelatedByFromWarehouseId($this);
    }

    /**
     * @param ChildStockTransaction $stockTransactionRelatedByFromWarehouseId The ChildStockTransaction object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeStockTransactionRelatedByFromWarehouseId(ChildStockTransaction $stockTransactionRelatedByFromWarehouseId)
    {
        if ($this->getStockTransactionsRelatedByFromWarehouseId()->contains($stockTransactionRelatedByFromWarehouseId)) {
            $pos = $this->collStockTransactionsRelatedByFromWarehouseId->search($stockTransactionRelatedByFromWarehouseId);
            $this->collStockTransactionsRelatedByFromWarehouseId->remove($pos);
            if (null === $this->stockTransactionsRelatedByFromWarehouseIdScheduledForDeletion) {
                $this->stockTransactionsRelatedByFromWarehouseIdScheduledForDeletion = clone $this->collStockTransactionsRelatedByFromWarehouseId;
                $this->stockTransactionsRelatedByFromWarehouseIdScheduledForDeletion->clear();
            }
            $this->stockTransactionsRelatedByFromWarehouseIdScheduledForDeletion[]= $stockTransactionRelatedByFromWarehouseId;
            $stockTransactionRelatedByFromWarehouseId->setWarehouseRelatedByFromWarehouseId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Warehouse is new, it will return
     * an empty collection; or if this Warehouse has previously
     * been saved, it will retrieve related StockTransactionsRelatedByFromWarehouseId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Warehouse.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStockTransaction[] List of ChildStockTransaction objects
     * @phpstan-return ObjectCollection&\Traversable<ChildStockTransaction}> List of ChildStockTransaction objects
     */
    public function getStockTransactionsRelatedByFromWarehouseIdJoinProduct(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStockTransactionQuery::create(null, $criteria);
        $query->joinWith('Product', $joinBehavior);

        return $this->getStockTransactionsRelatedByFromWarehouseId($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Warehouse is new, it will return
     * an empty collection; or if this Warehouse has previously
     * been saved, it will retrieve related StockTransactionsRelatedByFromWarehouseId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Warehouse.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStockTransaction[] List of ChildStockTransaction objects
     * @phpstan-return ObjectCollection&\Traversable<ChildStockTransaction}> List of ChildStockTransaction objects
     */
    public function getStockTransactionsRelatedByFromWarehouseIdJoinVehicle(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStockTransactionQuery::create(null, $criteria);
        $query->joinWith('Vehicle', $joinBehavior);

        return $this->getStockTransactionsRelatedByFromWarehouseId($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Warehouse is new, it will return
     * an empty collection; or if this Warehouse has previously
     * been saved, it will retrieve related StockTransactionsRelatedByFromWarehouseId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Warehouse.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStockTransaction[] List of ChildStockTransaction objects
     * @phpstan-return ObjectCollection&\Traversable<ChildStockTransaction}> List of ChildStockTransaction objects
     */
    public function getStockTransactionsRelatedByFromWarehouseIdJoinUser(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStockTransactionQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getStockTransactionsRelatedByFromWarehouseId($query, $con);
    }

    /**
     * Clears out the collStockTransactionsRelatedByToWarehouseId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addStockTransactionsRelatedByToWarehouseId()
     */
    public function clearStockTransactionsRelatedByToWarehouseId()
    {
        $this->collStockTransactionsRelatedByToWarehouseId = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collStockTransactionsRelatedByToWarehouseId collection loaded partially.
     *
     * @return void
     */
    public function resetPartialStockTransactionsRelatedByToWarehouseId($v = true): void
    {
        $this->collStockTransactionsRelatedByToWarehouseIdPartial = $v;
    }

    /**
     * Initializes the collStockTransactionsRelatedByToWarehouseId collection.
     *
     * By default this just sets the collStockTransactionsRelatedByToWarehouseId collection to an empty array (like clearcollStockTransactionsRelatedByToWarehouseId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStockTransactionsRelatedByToWarehouseId(bool $overrideExisting = true): void
    {
        if (null !== $this->collStockTransactionsRelatedByToWarehouseId && !$overrideExisting) {
            return;
        }

        $collectionClassName = StockTransactionTableMap::getTableMap()->getCollectionClassName();

        $this->collStockTransactionsRelatedByToWarehouseId = new $collectionClassName;
        $this->collStockTransactionsRelatedByToWarehouseId->setModel('\DbModel\StockTransaction');
    }

    /**
     * Gets an array of ChildStockTransaction objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildWarehouse is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStockTransaction[] List of ChildStockTransaction objects
     * @phpstan-return ObjectCollection&\Traversable<ChildStockTransaction> List of ChildStockTransaction objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getStockTransactionsRelatedByToWarehouseId(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collStockTransactionsRelatedByToWarehouseIdPartial && !$this->isNew();
        if (null === $this->collStockTransactionsRelatedByToWarehouseId || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collStockTransactionsRelatedByToWarehouseId) {
                    $this->initStockTransactionsRelatedByToWarehouseId();
                } else {
                    $collectionClassName = StockTransactionTableMap::getTableMap()->getCollectionClassName();

                    $collStockTransactionsRelatedByToWarehouseId = new $collectionClassName;
                    $collStockTransactionsRelatedByToWarehouseId->setModel('\DbModel\StockTransaction');

                    return $collStockTransactionsRelatedByToWarehouseId;
                }
            } else {
                $collStockTransactionsRelatedByToWarehouseId = ChildStockTransactionQuery::create(null, $criteria)
                    ->filterByWarehouseRelatedByToWarehouseId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStockTransactionsRelatedByToWarehouseIdPartial && count($collStockTransactionsRelatedByToWarehouseId)) {
                        $this->initStockTransactionsRelatedByToWarehouseId(false);

                        foreach ($collStockTransactionsRelatedByToWarehouseId as $obj) {
                            if (false == $this->collStockTransactionsRelatedByToWarehouseId->contains($obj)) {
                                $this->collStockTransactionsRelatedByToWarehouseId->append($obj);
                            }
                        }

                        $this->collStockTransactionsRelatedByToWarehouseIdPartial = true;
                    }

                    return $collStockTransactionsRelatedByToWarehouseId;
                }

                if ($partial && $this->collStockTransactionsRelatedByToWarehouseId) {
                    foreach ($this->collStockTransactionsRelatedByToWarehouseId as $obj) {
                        if ($obj->isNew()) {
                            $collStockTransactionsRelatedByToWarehouseId[] = $obj;
                        }
                    }
                }

                $this->collStockTransactionsRelatedByToWarehouseId = $collStockTransactionsRelatedByToWarehouseId;
                $this->collStockTransactionsRelatedByToWarehouseIdPartial = false;
            }
        }

        return $this->collStockTransactionsRelatedByToWarehouseId;
    }

    /**
     * Sets a collection of ChildStockTransaction objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $stockTransactionsRelatedByToWarehouseId A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setStockTransactionsRelatedByToWarehouseId(Collection $stockTransactionsRelatedByToWarehouseId, ?ConnectionInterface $con = null)
    {
        /** @var ChildStockTransaction[] $stockTransactionsRelatedByToWarehouseIdToDelete */
        $stockTransactionsRelatedByToWarehouseIdToDelete = $this->getStockTransactionsRelatedByToWarehouseId(new Criteria(), $con)->diff($stockTransactionsRelatedByToWarehouseId);


        $this->stockTransactionsRelatedByToWarehouseIdScheduledForDeletion = $stockTransactionsRelatedByToWarehouseIdToDelete;

        foreach ($stockTransactionsRelatedByToWarehouseIdToDelete as $stockTransactionRelatedByToWarehouseIdRemoved) {
            $stockTransactionRelatedByToWarehouseIdRemoved->setWarehouseRelatedByToWarehouseId(null);
        }

        $this->collStockTransactionsRelatedByToWarehouseId = null;
        foreach ($stockTransactionsRelatedByToWarehouseId as $stockTransactionRelatedByToWarehouseId) {
            $this->addStockTransactionRelatedByToWarehouseId($stockTransactionRelatedByToWarehouseId);
        }

        $this->collStockTransactionsRelatedByToWarehouseId = $stockTransactionsRelatedByToWarehouseId;
        $this->collStockTransactionsRelatedByToWarehouseIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related StockTransaction objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related StockTransaction objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countStockTransactionsRelatedByToWarehouseId(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collStockTransactionsRelatedByToWarehouseIdPartial && !$this->isNew();
        if (null === $this->collStockTransactionsRelatedByToWarehouseId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStockTransactionsRelatedByToWarehouseId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStockTransactionsRelatedByToWarehouseId());
            }

            $query = ChildStockTransactionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByWarehouseRelatedByToWarehouseId($this)
                ->count($con);
        }

        return count($this->collStockTransactionsRelatedByToWarehouseId);
    }

    /**
     * Method called to associate a ChildStockTransaction object to this object
     * through the ChildStockTransaction foreign key attribute.
     *
     * @param ChildStockTransaction $l ChildStockTransaction
     * @return $this The current object (for fluent API support)
     */
    public function addStockTransactionRelatedByToWarehouseId(ChildStockTransaction $l)
    {
        if ($this->collStockTransactionsRelatedByToWarehouseId === null) {
            $this->initStockTransactionsRelatedByToWarehouseId();
            $this->collStockTransactionsRelatedByToWarehouseIdPartial = true;
        }

        if (!$this->collStockTransactionsRelatedByToWarehouseId->contains($l)) {
            $this->doAddStockTransactionRelatedByToWarehouseId($l);

            if ($this->stockTransactionsRelatedByToWarehouseIdScheduledForDeletion and $this->stockTransactionsRelatedByToWarehouseIdScheduledForDeletion->contains($l)) {
                $this->stockTransactionsRelatedByToWarehouseIdScheduledForDeletion->remove($this->stockTransactionsRelatedByToWarehouseIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildStockTransaction $stockTransactionRelatedByToWarehouseId The ChildStockTransaction object to add.
     */
    protected function doAddStockTransactionRelatedByToWarehouseId(ChildStockTransaction $stockTransactionRelatedByToWarehouseId): void
    {
        $this->collStockTransactionsRelatedByToWarehouseId[]= $stockTransactionRelatedByToWarehouseId;
        $stockTransactionRelatedByToWarehouseId->setWarehouseRelatedByToWarehouseId($this);
    }

    /**
     * @param ChildStockTransaction $stockTransactionRelatedByToWarehouseId The ChildStockTransaction object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeStockTransactionRelatedByToWarehouseId(ChildStockTransaction $stockTransactionRelatedByToWarehouseId)
    {
        if ($this->getStockTransactionsRelatedByToWarehouseId()->contains($stockTransactionRelatedByToWarehouseId)) {
            $pos = $this->collStockTransactionsRelatedByToWarehouseId->search($stockTransactionRelatedByToWarehouseId);
            $this->collStockTransactionsRelatedByToWarehouseId->remove($pos);
            if (null === $this->stockTransactionsRelatedByToWarehouseIdScheduledForDeletion) {
                $this->stockTransactionsRelatedByToWarehouseIdScheduledForDeletion = clone $this->collStockTransactionsRelatedByToWarehouseId;
                $this->stockTransactionsRelatedByToWarehouseIdScheduledForDeletion->clear();
            }
            $this->stockTransactionsRelatedByToWarehouseIdScheduledForDeletion[]= $stockTransactionRelatedByToWarehouseId;
            $stockTransactionRelatedByToWarehouseId->setWarehouseRelatedByToWarehouseId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Warehouse is new, it will return
     * an empty collection; or if this Warehouse has previously
     * been saved, it will retrieve related StockTransactionsRelatedByToWarehouseId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Warehouse.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStockTransaction[] List of ChildStockTransaction objects
     * @phpstan-return ObjectCollection&\Traversable<ChildStockTransaction}> List of ChildStockTransaction objects
     */
    public function getStockTransactionsRelatedByToWarehouseIdJoinProduct(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStockTransactionQuery::create(null, $criteria);
        $query->joinWith('Product', $joinBehavior);

        return $this->getStockTransactionsRelatedByToWarehouseId($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Warehouse is new, it will return
     * an empty collection; or if this Warehouse has previously
     * been saved, it will retrieve related StockTransactionsRelatedByToWarehouseId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Warehouse.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStockTransaction[] List of ChildStockTransaction objects
     * @phpstan-return ObjectCollection&\Traversable<ChildStockTransaction}> List of ChildStockTransaction objects
     */
    public function getStockTransactionsRelatedByToWarehouseIdJoinVehicle(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStockTransactionQuery::create(null, $criteria);
        $query->joinWith('Vehicle', $joinBehavior);

        return $this->getStockTransactionsRelatedByToWarehouseId($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Warehouse is new, it will return
     * an empty collection; or if this Warehouse has previously
     * been saved, it will retrieve related StockTransactionsRelatedByToWarehouseId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Warehouse.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStockTransaction[] List of ChildStockTransaction objects
     * @phpstan-return ObjectCollection&\Traversable<ChildStockTransaction}> List of ChildStockTransaction objects
     */
    public function getStockTransactionsRelatedByToWarehouseIdJoinUser(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStockTransactionQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getStockTransactionsRelatedByToWarehouseId($query, $con);
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
     * If this ChildWarehouse is new, it will return
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
                    ->filterByWarehouse($this)
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
            $warehouseProductStockLogRemoved->setWarehouse(null);
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
                ->filterByWarehouse($this)
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
        $warehouseProductStockLog->setWarehouse($this);
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
            $warehouseProductStockLog->setWarehouse(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Warehouse is new, it will return
     * an empty collection; or if this Warehouse has previously
     * been saved, it will retrieve related WarehouseProductStockLogs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Warehouse.
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
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Warehouse is new, it will return
     * an empty collection; or if this Warehouse has previously
     * been saved, it will retrieve related WarehouseProductStockLogs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Warehouse.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildWarehouseProductStockLog[] List of ChildWarehouseProductStockLog objects
     * @phpstan-return ObjectCollection&\Traversable<ChildWarehouseProductStockLog}> List of ChildWarehouseProductStockLog objects
     */
    public function getWarehouseProductStockLogsJoinStockTransaction(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildWarehouseProductStockLogQuery::create(null, $criteria);
        $query->joinWith('StockTransaction', $joinBehavior);

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
            if ($this->collStockTransactionsRelatedByFromWarehouseId) {
                foreach ($this->collStockTransactionsRelatedByFromWarehouseId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStockTransactionsRelatedByToWarehouseId) {
                foreach ($this->collStockTransactionsRelatedByToWarehouseId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collWarehouseProductStockLogs) {
                foreach ($this->collWarehouseProductStockLogs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collStockTransactionsRelatedByFromWarehouseId = null;
        $this->collStockTransactionsRelatedByToWarehouseId = null;
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
        return (string) $this->exportTo(WarehouseTableMap::DEFAULT_STRING_FORMAT);
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
