<?php

namespace DbModel\Base;

use \Exception;
use \PDO;
use DbModel\StockTransaction as ChildStockTransaction;
use DbModel\StockTransactionQuery as ChildStockTransactionQuery;
use DbModel\Map\StockTransactionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `stock_transactions` table.
 *
 * @method     ChildStockTransactionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildStockTransactionQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildStockTransactionQuery orderByFromWarehouseId($order = Criteria::ASC) Order by the from_warehouse_id column
 * @method     ChildStockTransactionQuery orderByToWarehouseId($order = Criteria::ASC) Order by the to_warehouse_id column
 * @method     ChildStockTransactionQuery orderByVehicleId($order = Criteria::ASC) Order by the vehicle_id column
 * @method     ChildStockTransactionQuery orderByCreatorUserId($order = Criteria::ASC) Order by the creator_user_id column
 * @method     ChildStockTransactionQuery orderByAmount($order = Criteria::ASC) Order by the amount column
 * @method     ChildStockTransactionQuery orderByCreatedOn($order = Criteria::ASC) Order by the created_on column
 *
 * @method     ChildStockTransactionQuery groupById() Group by the id column
 * @method     ChildStockTransactionQuery groupByProductId() Group by the product_id column
 * @method     ChildStockTransactionQuery groupByFromWarehouseId() Group by the from_warehouse_id column
 * @method     ChildStockTransactionQuery groupByToWarehouseId() Group by the to_warehouse_id column
 * @method     ChildStockTransactionQuery groupByVehicleId() Group by the vehicle_id column
 * @method     ChildStockTransactionQuery groupByCreatorUserId() Group by the creator_user_id column
 * @method     ChildStockTransactionQuery groupByAmount() Group by the amount column
 * @method     ChildStockTransactionQuery groupByCreatedOn() Group by the created_on column
 *
 * @method     ChildStockTransactionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStockTransactionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStockTransactionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStockTransactionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildStockTransactionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildStockTransactionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildStockTransactionQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildStockTransactionQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildStockTransactionQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildStockTransactionQuery joinWithProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Product relation
 *
 * @method     ChildStockTransactionQuery leftJoinWithProduct() Adds a LEFT JOIN clause and with to the query using the Product relation
 * @method     ChildStockTransactionQuery rightJoinWithProduct() Adds a RIGHT JOIN clause and with to the query using the Product relation
 * @method     ChildStockTransactionQuery innerJoinWithProduct() Adds a INNER JOIN clause and with to the query using the Product relation
 *
 * @method     ChildStockTransactionQuery leftJoinWarehouseRelatedByFromWarehouseId($relationAlias = null) Adds a LEFT JOIN clause to the query using the WarehouseRelatedByFromWarehouseId relation
 * @method     ChildStockTransactionQuery rightJoinWarehouseRelatedByFromWarehouseId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WarehouseRelatedByFromWarehouseId relation
 * @method     ChildStockTransactionQuery innerJoinWarehouseRelatedByFromWarehouseId($relationAlias = null) Adds a INNER JOIN clause to the query using the WarehouseRelatedByFromWarehouseId relation
 *
 * @method     ChildStockTransactionQuery joinWithWarehouseRelatedByFromWarehouseId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WarehouseRelatedByFromWarehouseId relation
 *
 * @method     ChildStockTransactionQuery leftJoinWithWarehouseRelatedByFromWarehouseId() Adds a LEFT JOIN clause and with to the query using the WarehouseRelatedByFromWarehouseId relation
 * @method     ChildStockTransactionQuery rightJoinWithWarehouseRelatedByFromWarehouseId() Adds a RIGHT JOIN clause and with to the query using the WarehouseRelatedByFromWarehouseId relation
 * @method     ChildStockTransactionQuery innerJoinWithWarehouseRelatedByFromWarehouseId() Adds a INNER JOIN clause and with to the query using the WarehouseRelatedByFromWarehouseId relation
 *
 * @method     ChildStockTransactionQuery leftJoinWarehouseRelatedByToWarehouseId($relationAlias = null) Adds a LEFT JOIN clause to the query using the WarehouseRelatedByToWarehouseId relation
 * @method     ChildStockTransactionQuery rightJoinWarehouseRelatedByToWarehouseId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WarehouseRelatedByToWarehouseId relation
 * @method     ChildStockTransactionQuery innerJoinWarehouseRelatedByToWarehouseId($relationAlias = null) Adds a INNER JOIN clause to the query using the WarehouseRelatedByToWarehouseId relation
 *
 * @method     ChildStockTransactionQuery joinWithWarehouseRelatedByToWarehouseId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WarehouseRelatedByToWarehouseId relation
 *
 * @method     ChildStockTransactionQuery leftJoinWithWarehouseRelatedByToWarehouseId() Adds a LEFT JOIN clause and with to the query using the WarehouseRelatedByToWarehouseId relation
 * @method     ChildStockTransactionQuery rightJoinWithWarehouseRelatedByToWarehouseId() Adds a RIGHT JOIN clause and with to the query using the WarehouseRelatedByToWarehouseId relation
 * @method     ChildStockTransactionQuery innerJoinWithWarehouseRelatedByToWarehouseId() Adds a INNER JOIN clause and with to the query using the WarehouseRelatedByToWarehouseId relation
 *
 * @method     ChildStockTransactionQuery leftJoinVehicle($relationAlias = null) Adds a LEFT JOIN clause to the query using the Vehicle relation
 * @method     ChildStockTransactionQuery rightJoinVehicle($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Vehicle relation
 * @method     ChildStockTransactionQuery innerJoinVehicle($relationAlias = null) Adds a INNER JOIN clause to the query using the Vehicle relation
 *
 * @method     ChildStockTransactionQuery joinWithVehicle($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Vehicle relation
 *
 * @method     ChildStockTransactionQuery leftJoinWithVehicle() Adds a LEFT JOIN clause and with to the query using the Vehicle relation
 * @method     ChildStockTransactionQuery rightJoinWithVehicle() Adds a RIGHT JOIN clause and with to the query using the Vehicle relation
 * @method     ChildStockTransactionQuery innerJoinWithVehicle() Adds a INNER JOIN clause and with to the query using the Vehicle relation
 *
 * @method     ChildStockTransactionQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildStockTransactionQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildStockTransactionQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildStockTransactionQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildStockTransactionQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildStockTransactionQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildStockTransactionQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     ChildStockTransactionQuery leftJoinWarehouseProductStockLog($relationAlias = null) Adds a LEFT JOIN clause to the query using the WarehouseProductStockLog relation
 * @method     ChildStockTransactionQuery rightJoinWarehouseProductStockLog($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WarehouseProductStockLog relation
 * @method     ChildStockTransactionQuery innerJoinWarehouseProductStockLog($relationAlias = null) Adds a INNER JOIN clause to the query using the WarehouseProductStockLog relation
 *
 * @method     ChildStockTransactionQuery joinWithWarehouseProductStockLog($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WarehouseProductStockLog relation
 *
 * @method     ChildStockTransactionQuery leftJoinWithWarehouseProductStockLog() Adds a LEFT JOIN clause and with to the query using the WarehouseProductStockLog relation
 * @method     ChildStockTransactionQuery rightJoinWithWarehouseProductStockLog() Adds a RIGHT JOIN clause and with to the query using the WarehouseProductStockLog relation
 * @method     ChildStockTransactionQuery innerJoinWithWarehouseProductStockLog() Adds a INNER JOIN clause and with to the query using the WarehouseProductStockLog relation
 *
 * @method     \DbModel\ProductQuery|\DbModel\WarehouseQuery|\DbModel\WarehouseQuery|\DbModel\VehicleQuery|\DbModel\UserQuery|\DbModel\WarehouseProductStockLogQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildStockTransaction|null findOne(?ConnectionInterface $con = null) Return the first ChildStockTransaction matching the query
 * @method     ChildStockTransaction findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildStockTransaction matching the query, or a new ChildStockTransaction object populated from the query conditions when no match is found
 *
 * @method     ChildStockTransaction|null findOneById(int $id) Return the first ChildStockTransaction filtered by the id column
 * @method     ChildStockTransaction|null findOneByProductId(int $product_id) Return the first ChildStockTransaction filtered by the product_id column
 * @method     ChildStockTransaction|null findOneByFromWarehouseId(int $from_warehouse_id) Return the first ChildStockTransaction filtered by the from_warehouse_id column
 * @method     ChildStockTransaction|null findOneByToWarehouseId(int $to_warehouse_id) Return the first ChildStockTransaction filtered by the to_warehouse_id column
 * @method     ChildStockTransaction|null findOneByVehicleId(int $vehicle_id) Return the first ChildStockTransaction filtered by the vehicle_id column
 * @method     ChildStockTransaction|null findOneByCreatorUserId(int $creator_user_id) Return the first ChildStockTransaction filtered by the creator_user_id column
 * @method     ChildStockTransaction|null findOneByAmount(int $amount) Return the first ChildStockTransaction filtered by the amount column
 * @method     ChildStockTransaction|null findOneByCreatedOn(string $created_on) Return the first ChildStockTransaction filtered by the created_on column
 *
 * @method     ChildStockTransaction requirePk($key, ?ConnectionInterface $con = null) Return the ChildStockTransaction by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockTransaction requireOne(?ConnectionInterface $con = null) Return the first ChildStockTransaction matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStockTransaction requireOneById(int $id) Return the first ChildStockTransaction filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockTransaction requireOneByProductId(int $product_id) Return the first ChildStockTransaction filtered by the product_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockTransaction requireOneByFromWarehouseId(int $from_warehouse_id) Return the first ChildStockTransaction filtered by the from_warehouse_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockTransaction requireOneByToWarehouseId(int $to_warehouse_id) Return the first ChildStockTransaction filtered by the to_warehouse_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockTransaction requireOneByVehicleId(int $vehicle_id) Return the first ChildStockTransaction filtered by the vehicle_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockTransaction requireOneByCreatorUserId(int $creator_user_id) Return the first ChildStockTransaction filtered by the creator_user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockTransaction requireOneByAmount(int $amount) Return the first ChildStockTransaction filtered by the amount column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockTransaction requireOneByCreatedOn(string $created_on) Return the first ChildStockTransaction filtered by the created_on column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStockTransaction[]|Collection find(?ConnectionInterface $con = null) Return ChildStockTransaction objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildStockTransaction> find(?ConnectionInterface $con = null) Return ChildStockTransaction objects based on current ModelCriteria
 *
 * @method     ChildStockTransaction[]|Collection findById(int|array<int> $id) Return ChildStockTransaction objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildStockTransaction> findById(int|array<int> $id) Return ChildStockTransaction objects filtered by the id column
 * @method     ChildStockTransaction[]|Collection findByProductId(int|array<int> $product_id) Return ChildStockTransaction objects filtered by the product_id column
 * @psalm-method Collection&\Traversable<ChildStockTransaction> findByProductId(int|array<int> $product_id) Return ChildStockTransaction objects filtered by the product_id column
 * @method     ChildStockTransaction[]|Collection findByFromWarehouseId(int|array<int> $from_warehouse_id) Return ChildStockTransaction objects filtered by the from_warehouse_id column
 * @psalm-method Collection&\Traversable<ChildStockTransaction> findByFromWarehouseId(int|array<int> $from_warehouse_id) Return ChildStockTransaction objects filtered by the from_warehouse_id column
 * @method     ChildStockTransaction[]|Collection findByToWarehouseId(int|array<int> $to_warehouse_id) Return ChildStockTransaction objects filtered by the to_warehouse_id column
 * @psalm-method Collection&\Traversable<ChildStockTransaction> findByToWarehouseId(int|array<int> $to_warehouse_id) Return ChildStockTransaction objects filtered by the to_warehouse_id column
 * @method     ChildStockTransaction[]|Collection findByVehicleId(int|array<int> $vehicle_id) Return ChildStockTransaction objects filtered by the vehicle_id column
 * @psalm-method Collection&\Traversable<ChildStockTransaction> findByVehicleId(int|array<int> $vehicle_id) Return ChildStockTransaction objects filtered by the vehicle_id column
 * @method     ChildStockTransaction[]|Collection findByCreatorUserId(int|array<int> $creator_user_id) Return ChildStockTransaction objects filtered by the creator_user_id column
 * @psalm-method Collection&\Traversable<ChildStockTransaction> findByCreatorUserId(int|array<int> $creator_user_id) Return ChildStockTransaction objects filtered by the creator_user_id column
 * @method     ChildStockTransaction[]|Collection findByAmount(int|array<int> $amount) Return ChildStockTransaction objects filtered by the amount column
 * @psalm-method Collection&\Traversable<ChildStockTransaction> findByAmount(int|array<int> $amount) Return ChildStockTransaction objects filtered by the amount column
 * @method     ChildStockTransaction[]|Collection findByCreatedOn(string|array<string> $created_on) Return ChildStockTransaction objects filtered by the created_on column
 * @psalm-method Collection&\Traversable<ChildStockTransaction> findByCreatedOn(string|array<string> $created_on) Return ChildStockTransaction objects filtered by the created_on column
 *
 * @method     ChildStockTransaction[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildStockTransaction> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class StockTransactionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \DbModel\Base\StockTransactionQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DbModel\\StockTransaction', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStockTransactionQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStockTransactionQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildStockTransactionQuery) {
            return $criteria;
        }
        $query = new ChildStockTransactionQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildStockTransaction|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StockTransactionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = StockTransactionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildStockTransaction A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, product_id, from_warehouse_id, to_warehouse_id, vehicle_id, creator_user_id, amount, created_on FROM stock_transactions WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildStockTransaction $obj */
            $obj = new ChildStockTransaction();
            $obj->hydrate($row);
            StockTransactionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @return ChildStockTransaction|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param array $keys Primary keys to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return Collection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param mixed $key Primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        $this->addUsingAlias(StockTransactionTableMap::COL_ID, $key, Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array|int $keys The list of primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        $this->addUsingAlias(StockTransactionTableMap::COL_ID, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterById($id = null, ?string $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(StockTransactionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(StockTransactionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(StockTransactionTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the product_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProductId(1234); // WHERE product_id = 1234
     * $query->filterByProductId(array(12, 34)); // WHERE product_id IN (12, 34)
     * $query->filterByProductId(array('min' => 12)); // WHERE product_id > 12
     * </code>
     *
     * @see       filterByProduct()
     *
     * @param mixed $productId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByProductId($productId = null, ?string $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(StockTransactionTableMap::COL_PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(StockTransactionTableMap::COL_PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(StockTransactionTableMap::COL_PRODUCT_ID, $productId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the from_warehouse_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFromWarehouseId(1234); // WHERE from_warehouse_id = 1234
     * $query->filterByFromWarehouseId(array(12, 34)); // WHERE from_warehouse_id IN (12, 34)
     * $query->filterByFromWarehouseId(array('min' => 12)); // WHERE from_warehouse_id > 12
     * </code>
     *
     * @see       filterByWarehouseRelatedByFromWarehouseId()
     *
     * @param mixed $fromWarehouseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByFromWarehouseId($fromWarehouseId = null, ?string $comparison = null)
    {
        if (is_array($fromWarehouseId)) {
            $useMinMax = false;
            if (isset($fromWarehouseId['min'])) {
                $this->addUsingAlias(StockTransactionTableMap::COL_FROM_WAREHOUSE_ID, $fromWarehouseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fromWarehouseId['max'])) {
                $this->addUsingAlias(StockTransactionTableMap::COL_FROM_WAREHOUSE_ID, $fromWarehouseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(StockTransactionTableMap::COL_FROM_WAREHOUSE_ID, $fromWarehouseId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the to_warehouse_id column
     *
     * Example usage:
     * <code>
     * $query->filterByToWarehouseId(1234); // WHERE to_warehouse_id = 1234
     * $query->filterByToWarehouseId(array(12, 34)); // WHERE to_warehouse_id IN (12, 34)
     * $query->filterByToWarehouseId(array('min' => 12)); // WHERE to_warehouse_id > 12
     * </code>
     *
     * @see       filterByWarehouseRelatedByToWarehouseId()
     *
     * @param mixed $toWarehouseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByToWarehouseId($toWarehouseId = null, ?string $comparison = null)
    {
        if (is_array($toWarehouseId)) {
            $useMinMax = false;
            if (isset($toWarehouseId['min'])) {
                $this->addUsingAlias(StockTransactionTableMap::COL_TO_WAREHOUSE_ID, $toWarehouseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($toWarehouseId['max'])) {
                $this->addUsingAlias(StockTransactionTableMap::COL_TO_WAREHOUSE_ID, $toWarehouseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(StockTransactionTableMap::COL_TO_WAREHOUSE_ID, $toWarehouseId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the vehicle_id column
     *
     * Example usage:
     * <code>
     * $query->filterByVehicleId(1234); // WHERE vehicle_id = 1234
     * $query->filterByVehicleId(array(12, 34)); // WHERE vehicle_id IN (12, 34)
     * $query->filterByVehicleId(array('min' => 12)); // WHERE vehicle_id > 12
     * </code>
     *
     * @see       filterByVehicle()
     *
     * @param mixed $vehicleId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByVehicleId($vehicleId = null, ?string $comparison = null)
    {
        if (is_array($vehicleId)) {
            $useMinMax = false;
            if (isset($vehicleId['min'])) {
                $this->addUsingAlias(StockTransactionTableMap::COL_VEHICLE_ID, $vehicleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vehicleId['max'])) {
                $this->addUsingAlias(StockTransactionTableMap::COL_VEHICLE_ID, $vehicleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(StockTransactionTableMap::COL_VEHICLE_ID, $vehicleId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the creator_user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatorUserId(1234); // WHERE creator_user_id = 1234
     * $query->filterByCreatorUserId(array(12, 34)); // WHERE creator_user_id IN (12, 34)
     * $query->filterByCreatorUserId(array('min' => 12)); // WHERE creator_user_id > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param mixed $creatorUserId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCreatorUserId($creatorUserId = null, ?string $comparison = null)
    {
        if (is_array($creatorUserId)) {
            $useMinMax = false;
            if (isset($creatorUserId['min'])) {
                $this->addUsingAlias(StockTransactionTableMap::COL_CREATOR_USER_ID, $creatorUserId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($creatorUserId['max'])) {
                $this->addUsingAlias(StockTransactionTableMap::COL_CREATOR_USER_ID, $creatorUserId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(StockTransactionTableMap::COL_CREATOR_USER_ID, $creatorUserId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the amount column
     *
     * Example usage:
     * <code>
     * $query->filterByAmount(1234); // WHERE amount = 1234
     * $query->filterByAmount(array(12, 34)); // WHERE amount IN (12, 34)
     * $query->filterByAmount(array('min' => 12)); // WHERE amount > 12
     * </code>
     *
     * @param mixed $amount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByAmount($amount = null, ?string $comparison = null)
    {
        if (is_array($amount)) {
            $useMinMax = false;
            if (isset($amount['min'])) {
                $this->addUsingAlias(StockTransactionTableMap::COL_AMOUNT, $amount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amount['max'])) {
                $this->addUsingAlias(StockTransactionTableMap::COL_AMOUNT, $amount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(StockTransactionTableMap::COL_AMOUNT, $amount, $comparison);

        return $this;
    }

    /**
     * Filter the query on the created_on column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedOn('2011-03-14'); // WHERE created_on = '2011-03-14'
     * $query->filterByCreatedOn('now'); // WHERE created_on = '2011-03-14'
     * $query->filterByCreatedOn(array('max' => 'yesterday')); // WHERE created_on > '2011-03-13'
     * </code>
     *
     * @param mixed $createdOn The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCreatedOn($createdOn = null, ?string $comparison = null)
    {
        if (is_array($createdOn)) {
            $useMinMax = false;
            if (isset($createdOn['min'])) {
                $this->addUsingAlias(StockTransactionTableMap::COL_CREATED_ON, $createdOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdOn['max'])) {
                $this->addUsingAlias(StockTransactionTableMap::COL_CREATED_ON, $createdOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(StockTransactionTableMap::COL_CREATED_ON, $createdOn, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \DbModel\Product object
     *
     * @param \DbModel\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByProduct($product, ?string $comparison = null)
    {
        if ($product instanceof \DbModel\Product) {
            return $this
                ->addUsingAlias(StockTransactionTableMap::COL_PRODUCT_ID, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(StockTransactionTableMap::COL_PRODUCT_ID, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByProduct() only accepts arguments of type \DbModel\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Product relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinProduct(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Product');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Product');
        }

        return $this;
    }

    /**
     * Use the Product relation Product object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DbModel\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Product', '\DbModel\ProductQuery');
    }

    /**
     * Use the Product relation Product object
     *
     * @param callable(\DbModel\ProductQuery):\DbModel\ProductQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withProductQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useProductQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Product table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \DbModel\ProductQuery The inner query object of the EXISTS statement
     */
    public function useProductExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \DbModel\ProductQuery */
        $q = $this->useExistsQuery('Product', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Product table for a NOT EXISTS query.
     *
     * @see useProductExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \DbModel\ProductQuery The inner query object of the NOT EXISTS statement
     */
    public function useProductNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\ProductQuery */
        $q = $this->useExistsQuery('Product', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Product table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \DbModel\ProductQuery The inner query object of the IN statement
     */
    public function useInProductQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \DbModel\ProductQuery */
        $q = $this->useInQuery('Product', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Product table for a NOT IN query.
     *
     * @see useProductInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \DbModel\ProductQuery The inner query object of the NOT IN statement
     */
    public function useNotInProductQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\ProductQuery */
        $q = $this->useInQuery('Product', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \DbModel\Warehouse object
     *
     * @param \DbModel\Warehouse|ObjectCollection $warehouse The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByWarehouseRelatedByFromWarehouseId($warehouse, ?string $comparison = null)
    {
        if ($warehouse instanceof \DbModel\Warehouse) {
            return $this
                ->addUsingAlias(StockTransactionTableMap::COL_FROM_WAREHOUSE_ID, $warehouse->getId(), $comparison);
        } elseif ($warehouse instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(StockTransactionTableMap::COL_FROM_WAREHOUSE_ID, $warehouse->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByWarehouseRelatedByFromWarehouseId() only accepts arguments of type \DbModel\Warehouse or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WarehouseRelatedByFromWarehouseId relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinWarehouseRelatedByFromWarehouseId(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WarehouseRelatedByFromWarehouseId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'WarehouseRelatedByFromWarehouseId');
        }

        return $this;
    }

    /**
     * Use the WarehouseRelatedByFromWarehouseId relation Warehouse object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DbModel\WarehouseQuery A secondary query class using the current class as primary query
     */
    public function useWarehouseRelatedByFromWarehouseIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinWarehouseRelatedByFromWarehouseId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WarehouseRelatedByFromWarehouseId', '\DbModel\WarehouseQuery');
    }

    /**
     * Use the WarehouseRelatedByFromWarehouseId relation Warehouse object
     *
     * @param callable(\DbModel\WarehouseQuery):\DbModel\WarehouseQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withWarehouseRelatedByFromWarehouseIdQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useWarehouseRelatedByFromWarehouseIdQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the WarehouseRelatedByFromWarehouseId relation to the Warehouse table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \DbModel\WarehouseQuery The inner query object of the EXISTS statement
     */
    public function useWarehouseRelatedByFromWarehouseIdExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \DbModel\WarehouseQuery */
        $q = $this->useExistsQuery('WarehouseRelatedByFromWarehouseId', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the WarehouseRelatedByFromWarehouseId relation to the Warehouse table for a NOT EXISTS query.
     *
     * @see useWarehouseRelatedByFromWarehouseIdExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \DbModel\WarehouseQuery The inner query object of the NOT EXISTS statement
     */
    public function useWarehouseRelatedByFromWarehouseIdNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\WarehouseQuery */
        $q = $this->useExistsQuery('WarehouseRelatedByFromWarehouseId', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the WarehouseRelatedByFromWarehouseId relation to the Warehouse table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \DbModel\WarehouseQuery The inner query object of the IN statement
     */
    public function useInWarehouseRelatedByFromWarehouseIdQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \DbModel\WarehouseQuery */
        $q = $this->useInQuery('WarehouseRelatedByFromWarehouseId', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the WarehouseRelatedByFromWarehouseId relation to the Warehouse table for a NOT IN query.
     *
     * @see useWarehouseRelatedByFromWarehouseIdInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \DbModel\WarehouseQuery The inner query object of the NOT IN statement
     */
    public function useNotInWarehouseRelatedByFromWarehouseIdQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\WarehouseQuery */
        $q = $this->useInQuery('WarehouseRelatedByFromWarehouseId', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \DbModel\Warehouse object
     *
     * @param \DbModel\Warehouse|ObjectCollection $warehouse The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByWarehouseRelatedByToWarehouseId($warehouse, ?string $comparison = null)
    {
        if ($warehouse instanceof \DbModel\Warehouse) {
            return $this
                ->addUsingAlias(StockTransactionTableMap::COL_TO_WAREHOUSE_ID, $warehouse->getId(), $comparison);
        } elseif ($warehouse instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(StockTransactionTableMap::COL_TO_WAREHOUSE_ID, $warehouse->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByWarehouseRelatedByToWarehouseId() only accepts arguments of type \DbModel\Warehouse or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WarehouseRelatedByToWarehouseId relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinWarehouseRelatedByToWarehouseId(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WarehouseRelatedByToWarehouseId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'WarehouseRelatedByToWarehouseId');
        }

        return $this;
    }

    /**
     * Use the WarehouseRelatedByToWarehouseId relation Warehouse object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DbModel\WarehouseQuery A secondary query class using the current class as primary query
     */
    public function useWarehouseRelatedByToWarehouseIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinWarehouseRelatedByToWarehouseId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WarehouseRelatedByToWarehouseId', '\DbModel\WarehouseQuery');
    }

    /**
     * Use the WarehouseRelatedByToWarehouseId relation Warehouse object
     *
     * @param callable(\DbModel\WarehouseQuery):\DbModel\WarehouseQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withWarehouseRelatedByToWarehouseIdQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useWarehouseRelatedByToWarehouseIdQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the WarehouseRelatedByToWarehouseId relation to the Warehouse table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \DbModel\WarehouseQuery The inner query object of the EXISTS statement
     */
    public function useWarehouseRelatedByToWarehouseIdExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \DbModel\WarehouseQuery */
        $q = $this->useExistsQuery('WarehouseRelatedByToWarehouseId', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the WarehouseRelatedByToWarehouseId relation to the Warehouse table for a NOT EXISTS query.
     *
     * @see useWarehouseRelatedByToWarehouseIdExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \DbModel\WarehouseQuery The inner query object of the NOT EXISTS statement
     */
    public function useWarehouseRelatedByToWarehouseIdNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\WarehouseQuery */
        $q = $this->useExistsQuery('WarehouseRelatedByToWarehouseId', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the WarehouseRelatedByToWarehouseId relation to the Warehouse table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \DbModel\WarehouseQuery The inner query object of the IN statement
     */
    public function useInWarehouseRelatedByToWarehouseIdQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \DbModel\WarehouseQuery */
        $q = $this->useInQuery('WarehouseRelatedByToWarehouseId', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the WarehouseRelatedByToWarehouseId relation to the Warehouse table for a NOT IN query.
     *
     * @see useWarehouseRelatedByToWarehouseIdInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \DbModel\WarehouseQuery The inner query object of the NOT IN statement
     */
    public function useNotInWarehouseRelatedByToWarehouseIdQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\WarehouseQuery */
        $q = $this->useInQuery('WarehouseRelatedByToWarehouseId', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \DbModel\Vehicle object
     *
     * @param \DbModel\Vehicle|ObjectCollection $vehicle The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByVehicle($vehicle, ?string $comparison = null)
    {
        if ($vehicle instanceof \DbModel\Vehicle) {
            return $this
                ->addUsingAlias(StockTransactionTableMap::COL_VEHICLE_ID, $vehicle->getId(), $comparison);
        } elseif ($vehicle instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(StockTransactionTableMap::COL_VEHICLE_ID, $vehicle->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByVehicle() only accepts arguments of type \DbModel\Vehicle or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Vehicle relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinVehicle(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Vehicle');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Vehicle');
        }

        return $this;
    }

    /**
     * Use the Vehicle relation Vehicle object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DbModel\VehicleQuery A secondary query class using the current class as primary query
     */
    public function useVehicleQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinVehicle($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Vehicle', '\DbModel\VehicleQuery');
    }

    /**
     * Use the Vehicle relation Vehicle object
     *
     * @param callable(\DbModel\VehicleQuery):\DbModel\VehicleQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withVehicleQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useVehicleQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Vehicle table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \DbModel\VehicleQuery The inner query object of the EXISTS statement
     */
    public function useVehicleExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \DbModel\VehicleQuery */
        $q = $this->useExistsQuery('Vehicle', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Vehicle table for a NOT EXISTS query.
     *
     * @see useVehicleExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \DbModel\VehicleQuery The inner query object of the NOT EXISTS statement
     */
    public function useVehicleNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\VehicleQuery */
        $q = $this->useExistsQuery('Vehicle', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Vehicle table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \DbModel\VehicleQuery The inner query object of the IN statement
     */
    public function useInVehicleQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \DbModel\VehicleQuery */
        $q = $this->useInQuery('Vehicle', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Vehicle table for a NOT IN query.
     *
     * @see useVehicleInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \DbModel\VehicleQuery The inner query object of the NOT IN statement
     */
    public function useNotInVehicleQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\VehicleQuery */
        $q = $this->useInQuery('Vehicle', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \DbModel\User object
     *
     * @param \DbModel\User|ObjectCollection $user The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByUser($user, ?string $comparison = null)
    {
        if ($user instanceof \DbModel\User) {
            return $this
                ->addUsingAlias(StockTransactionTableMap::COL_CREATOR_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(StockTransactionTableMap::COL_CREATOR_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \DbModel\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinUser(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DbModel\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\DbModel\UserQuery');
    }

    /**
     * Use the User relation User object
     *
     * @param callable(\DbModel\UserQuery):\DbModel\UserQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withUserQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useUserQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to User table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \DbModel\UserQuery The inner query object of the EXISTS statement
     */
    public function useUserExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \DbModel\UserQuery */
        $q = $this->useExistsQuery('User', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to User table for a NOT EXISTS query.
     *
     * @see useUserExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \DbModel\UserQuery The inner query object of the NOT EXISTS statement
     */
    public function useUserNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\UserQuery */
        $q = $this->useExistsQuery('User', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to User table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \DbModel\UserQuery The inner query object of the IN statement
     */
    public function useInUserQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \DbModel\UserQuery */
        $q = $this->useInQuery('User', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to User table for a NOT IN query.
     *
     * @see useUserInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \DbModel\UserQuery The inner query object of the NOT IN statement
     */
    public function useNotInUserQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\UserQuery */
        $q = $this->useInQuery('User', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \DbModel\WarehouseProductStockLog object
     *
     * @param \DbModel\WarehouseProductStockLog|ObjectCollection $warehouseProductStockLog the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByWarehouseProductStockLog($warehouseProductStockLog, ?string $comparison = null)
    {
        if ($warehouseProductStockLog instanceof \DbModel\WarehouseProductStockLog) {
            $this
                ->addUsingAlias(StockTransactionTableMap::COL_ID, $warehouseProductStockLog->getRelatedTransactionId(), $comparison);

            return $this;
        } elseif ($warehouseProductStockLog instanceof ObjectCollection) {
            $this
                ->useWarehouseProductStockLogQuery()
                ->filterByPrimaryKeys($warehouseProductStockLog->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByWarehouseProductStockLog() only accepts arguments of type \DbModel\WarehouseProductStockLog or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WarehouseProductStockLog relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinWarehouseProductStockLog(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WarehouseProductStockLog');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'WarehouseProductStockLog');
        }

        return $this;
    }

    /**
     * Use the WarehouseProductStockLog relation WarehouseProductStockLog object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DbModel\WarehouseProductStockLogQuery A secondary query class using the current class as primary query
     */
    public function useWarehouseProductStockLogQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinWarehouseProductStockLog($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WarehouseProductStockLog', '\DbModel\WarehouseProductStockLogQuery');
    }

    /**
     * Use the WarehouseProductStockLog relation WarehouseProductStockLog object
     *
     * @param callable(\DbModel\WarehouseProductStockLogQuery):\DbModel\WarehouseProductStockLogQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withWarehouseProductStockLogQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useWarehouseProductStockLogQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to WarehouseProductStockLog table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \DbModel\WarehouseProductStockLogQuery The inner query object of the EXISTS statement
     */
    public function useWarehouseProductStockLogExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \DbModel\WarehouseProductStockLogQuery */
        $q = $this->useExistsQuery('WarehouseProductStockLog', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to WarehouseProductStockLog table for a NOT EXISTS query.
     *
     * @see useWarehouseProductStockLogExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \DbModel\WarehouseProductStockLogQuery The inner query object of the NOT EXISTS statement
     */
    public function useWarehouseProductStockLogNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\WarehouseProductStockLogQuery */
        $q = $this->useExistsQuery('WarehouseProductStockLog', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to WarehouseProductStockLog table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \DbModel\WarehouseProductStockLogQuery The inner query object of the IN statement
     */
    public function useInWarehouseProductStockLogQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \DbModel\WarehouseProductStockLogQuery */
        $q = $this->useInQuery('WarehouseProductStockLog', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to WarehouseProductStockLog table for a NOT IN query.
     *
     * @see useWarehouseProductStockLogInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \DbModel\WarehouseProductStockLogQuery The inner query object of the NOT IN statement
     */
    public function useNotInWarehouseProductStockLogQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\WarehouseProductStockLogQuery */
        $q = $this->useInQuery('WarehouseProductStockLog', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildStockTransaction $stockTransaction Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($stockTransaction = null)
    {
        if ($stockTransaction) {
            $this->addUsingAlias(StockTransactionTableMap::COL_ID, $stockTransaction->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the stock_transactions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockTransactionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StockTransactionTableMap::clearInstancePool();
            StockTransactionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockTransactionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StockTransactionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            StockTransactionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StockTransactionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
