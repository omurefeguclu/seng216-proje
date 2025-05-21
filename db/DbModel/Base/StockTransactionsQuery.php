<?php

namespace DbModel\Base;

use \Exception;
use \PDO;
use DbModel\StockTransactions as ChildStockTransactions;
use DbModel\StockTransactionsQuery as ChildStockTransactionsQuery;
use DbModel\Map\StockTransactionsTableMap;
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
 * @method     ChildStockTransactionsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildStockTransactionsQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildStockTransactionsQuery orderByFromWarehouseId($order = Criteria::ASC) Order by the from_warehouse_id column
 * @method     ChildStockTransactionsQuery orderByToWarehouseId($order = Criteria::ASC) Order by the to_warehouse_id column
 * @method     ChildStockTransactionsQuery orderByVehicleId($order = Criteria::ASC) Order by the vehicle_id column
 * @method     ChildStockTransactionsQuery orderByCreatorUserId($order = Criteria::ASC) Order by the creator_user_id column
 * @method     ChildStockTransactionsQuery orderByAmount($order = Criteria::ASC) Order by the amount column
 * @method     ChildStockTransactionsQuery orderByCreatedOn($order = Criteria::ASC) Order by the created_on column
 *
 * @method     ChildStockTransactionsQuery groupById() Group by the id column
 * @method     ChildStockTransactionsQuery groupByProductId() Group by the product_id column
 * @method     ChildStockTransactionsQuery groupByFromWarehouseId() Group by the from_warehouse_id column
 * @method     ChildStockTransactionsQuery groupByToWarehouseId() Group by the to_warehouse_id column
 * @method     ChildStockTransactionsQuery groupByVehicleId() Group by the vehicle_id column
 * @method     ChildStockTransactionsQuery groupByCreatorUserId() Group by the creator_user_id column
 * @method     ChildStockTransactionsQuery groupByAmount() Group by the amount column
 * @method     ChildStockTransactionsQuery groupByCreatedOn() Group by the created_on column
 *
 * @method     ChildStockTransactionsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStockTransactionsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStockTransactionsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStockTransactionsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildStockTransactionsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildStockTransactionsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildStockTransactionsQuery leftJoinProducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the Products relation
 * @method     ChildStockTransactionsQuery rightJoinProducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Products relation
 * @method     ChildStockTransactionsQuery innerJoinProducts($relationAlias = null) Adds a INNER JOIN clause to the query using the Products relation
 *
 * @method     ChildStockTransactionsQuery joinWithProducts($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Products relation
 *
 * @method     ChildStockTransactionsQuery leftJoinWithProducts() Adds a LEFT JOIN clause and with to the query using the Products relation
 * @method     ChildStockTransactionsQuery rightJoinWithProducts() Adds a RIGHT JOIN clause and with to the query using the Products relation
 * @method     ChildStockTransactionsQuery innerJoinWithProducts() Adds a INNER JOIN clause and with to the query using the Products relation
 *
 * @method     ChildStockTransactionsQuery leftJoinWarehousesRelatedByFromWarehouseId($relationAlias = null) Adds a LEFT JOIN clause to the query using the WarehousesRelatedByFromWarehouseId relation
 * @method     ChildStockTransactionsQuery rightJoinWarehousesRelatedByFromWarehouseId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WarehousesRelatedByFromWarehouseId relation
 * @method     ChildStockTransactionsQuery innerJoinWarehousesRelatedByFromWarehouseId($relationAlias = null) Adds a INNER JOIN clause to the query using the WarehousesRelatedByFromWarehouseId relation
 *
 * @method     ChildStockTransactionsQuery joinWithWarehousesRelatedByFromWarehouseId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WarehousesRelatedByFromWarehouseId relation
 *
 * @method     ChildStockTransactionsQuery leftJoinWithWarehousesRelatedByFromWarehouseId() Adds a LEFT JOIN clause and with to the query using the WarehousesRelatedByFromWarehouseId relation
 * @method     ChildStockTransactionsQuery rightJoinWithWarehousesRelatedByFromWarehouseId() Adds a RIGHT JOIN clause and with to the query using the WarehousesRelatedByFromWarehouseId relation
 * @method     ChildStockTransactionsQuery innerJoinWithWarehousesRelatedByFromWarehouseId() Adds a INNER JOIN clause and with to the query using the WarehousesRelatedByFromWarehouseId relation
 *
 * @method     ChildStockTransactionsQuery leftJoinWarehousesRelatedByToWarehouseId($relationAlias = null) Adds a LEFT JOIN clause to the query using the WarehousesRelatedByToWarehouseId relation
 * @method     ChildStockTransactionsQuery rightJoinWarehousesRelatedByToWarehouseId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WarehousesRelatedByToWarehouseId relation
 * @method     ChildStockTransactionsQuery innerJoinWarehousesRelatedByToWarehouseId($relationAlias = null) Adds a INNER JOIN clause to the query using the WarehousesRelatedByToWarehouseId relation
 *
 * @method     ChildStockTransactionsQuery joinWithWarehousesRelatedByToWarehouseId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WarehousesRelatedByToWarehouseId relation
 *
 * @method     ChildStockTransactionsQuery leftJoinWithWarehousesRelatedByToWarehouseId() Adds a LEFT JOIN clause and with to the query using the WarehousesRelatedByToWarehouseId relation
 * @method     ChildStockTransactionsQuery rightJoinWithWarehousesRelatedByToWarehouseId() Adds a RIGHT JOIN clause and with to the query using the WarehousesRelatedByToWarehouseId relation
 * @method     ChildStockTransactionsQuery innerJoinWithWarehousesRelatedByToWarehouseId() Adds a INNER JOIN clause and with to the query using the WarehousesRelatedByToWarehouseId relation
 *
 * @method     ChildStockTransactionsQuery leftJoinVehicles($relationAlias = null) Adds a LEFT JOIN clause to the query using the Vehicles relation
 * @method     ChildStockTransactionsQuery rightJoinVehicles($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Vehicles relation
 * @method     ChildStockTransactionsQuery innerJoinVehicles($relationAlias = null) Adds a INNER JOIN clause to the query using the Vehicles relation
 *
 * @method     ChildStockTransactionsQuery joinWithVehicles($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Vehicles relation
 *
 * @method     ChildStockTransactionsQuery leftJoinWithVehicles() Adds a LEFT JOIN clause and with to the query using the Vehicles relation
 * @method     ChildStockTransactionsQuery rightJoinWithVehicles() Adds a RIGHT JOIN clause and with to the query using the Vehicles relation
 * @method     ChildStockTransactionsQuery innerJoinWithVehicles() Adds a INNER JOIN clause and with to the query using the Vehicles relation
 *
 * @method     ChildStockTransactionsQuery leftJoinUsers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Users relation
 * @method     ChildStockTransactionsQuery rightJoinUsers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Users relation
 * @method     ChildStockTransactionsQuery innerJoinUsers($relationAlias = null) Adds a INNER JOIN clause to the query using the Users relation
 *
 * @method     ChildStockTransactionsQuery joinWithUsers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Users relation
 *
 * @method     ChildStockTransactionsQuery leftJoinWithUsers() Adds a LEFT JOIN clause and with to the query using the Users relation
 * @method     ChildStockTransactionsQuery rightJoinWithUsers() Adds a RIGHT JOIN clause and with to the query using the Users relation
 * @method     ChildStockTransactionsQuery innerJoinWithUsers() Adds a INNER JOIN clause and with to the query using the Users relation
 *
 * @method     \DbModel\ProductsQuery|\DbModel\WarehousesQuery|\DbModel\WarehousesQuery|\DbModel\VehiclesQuery|\DbModel\UsersQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildStockTransactions|null findOne(?ConnectionInterface $con = null) Return the first ChildStockTransactions matching the query
 * @method     ChildStockTransactions findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildStockTransactions matching the query, or a new ChildStockTransactions object populated from the query conditions when no match is found
 *
 * @method     ChildStockTransactions|null findOneById(int $id) Return the first ChildStockTransactions filtered by the id column
 * @method     ChildStockTransactions|null findOneByProductId(int $product_id) Return the first ChildStockTransactions filtered by the product_id column
 * @method     ChildStockTransactions|null findOneByFromWarehouseId(int $from_warehouse_id) Return the first ChildStockTransactions filtered by the from_warehouse_id column
 * @method     ChildStockTransactions|null findOneByToWarehouseId(int $to_warehouse_id) Return the first ChildStockTransactions filtered by the to_warehouse_id column
 * @method     ChildStockTransactions|null findOneByVehicleId(int $vehicle_id) Return the first ChildStockTransactions filtered by the vehicle_id column
 * @method     ChildStockTransactions|null findOneByCreatorUserId(int $creator_user_id) Return the first ChildStockTransactions filtered by the creator_user_id column
 * @method     ChildStockTransactions|null findOneByAmount(int $amount) Return the first ChildStockTransactions filtered by the amount column
 * @method     ChildStockTransactions|null findOneByCreatedOn(string $created_on) Return the first ChildStockTransactions filtered by the created_on column
 *
 * @method     ChildStockTransactions requirePk($key, ?ConnectionInterface $con = null) Return the ChildStockTransactions by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockTransactions requireOne(?ConnectionInterface $con = null) Return the first ChildStockTransactions matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStockTransactions requireOneById(int $id) Return the first ChildStockTransactions filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockTransactions requireOneByProductId(int $product_id) Return the first ChildStockTransactions filtered by the product_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockTransactions requireOneByFromWarehouseId(int $from_warehouse_id) Return the first ChildStockTransactions filtered by the from_warehouse_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockTransactions requireOneByToWarehouseId(int $to_warehouse_id) Return the first ChildStockTransactions filtered by the to_warehouse_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockTransactions requireOneByVehicleId(int $vehicle_id) Return the first ChildStockTransactions filtered by the vehicle_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockTransactions requireOneByCreatorUserId(int $creator_user_id) Return the first ChildStockTransactions filtered by the creator_user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockTransactions requireOneByAmount(int $amount) Return the first ChildStockTransactions filtered by the amount column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockTransactions requireOneByCreatedOn(string $created_on) Return the first ChildStockTransactions filtered by the created_on column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStockTransactions[]|Collection find(?ConnectionInterface $con = null) Return ChildStockTransactions objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildStockTransactions> find(?ConnectionInterface $con = null) Return ChildStockTransactions objects based on current ModelCriteria
 *
 * @method     ChildStockTransactions[]|Collection findById(int|array<int> $id) Return ChildStockTransactions objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildStockTransactions> findById(int|array<int> $id) Return ChildStockTransactions objects filtered by the id column
 * @method     ChildStockTransactions[]|Collection findByProductId(int|array<int> $product_id) Return ChildStockTransactions objects filtered by the product_id column
 * @psalm-method Collection&\Traversable<ChildStockTransactions> findByProductId(int|array<int> $product_id) Return ChildStockTransactions objects filtered by the product_id column
 * @method     ChildStockTransactions[]|Collection findByFromWarehouseId(int|array<int> $from_warehouse_id) Return ChildStockTransactions objects filtered by the from_warehouse_id column
 * @psalm-method Collection&\Traversable<ChildStockTransactions> findByFromWarehouseId(int|array<int> $from_warehouse_id) Return ChildStockTransactions objects filtered by the from_warehouse_id column
 * @method     ChildStockTransactions[]|Collection findByToWarehouseId(int|array<int> $to_warehouse_id) Return ChildStockTransactions objects filtered by the to_warehouse_id column
 * @psalm-method Collection&\Traversable<ChildStockTransactions> findByToWarehouseId(int|array<int> $to_warehouse_id) Return ChildStockTransactions objects filtered by the to_warehouse_id column
 * @method     ChildStockTransactions[]|Collection findByVehicleId(int|array<int> $vehicle_id) Return ChildStockTransactions objects filtered by the vehicle_id column
 * @psalm-method Collection&\Traversable<ChildStockTransactions> findByVehicleId(int|array<int> $vehicle_id) Return ChildStockTransactions objects filtered by the vehicle_id column
 * @method     ChildStockTransactions[]|Collection findByCreatorUserId(int|array<int> $creator_user_id) Return ChildStockTransactions objects filtered by the creator_user_id column
 * @psalm-method Collection&\Traversable<ChildStockTransactions> findByCreatorUserId(int|array<int> $creator_user_id) Return ChildStockTransactions objects filtered by the creator_user_id column
 * @method     ChildStockTransactions[]|Collection findByAmount(int|array<int> $amount) Return ChildStockTransactions objects filtered by the amount column
 * @psalm-method Collection&\Traversable<ChildStockTransactions> findByAmount(int|array<int> $amount) Return ChildStockTransactions objects filtered by the amount column
 * @method     ChildStockTransactions[]|Collection findByCreatedOn(string|array<string> $created_on) Return ChildStockTransactions objects filtered by the created_on column
 * @psalm-method Collection&\Traversable<ChildStockTransactions> findByCreatedOn(string|array<string> $created_on) Return ChildStockTransactions objects filtered by the created_on column
 *
 * @method     ChildStockTransactions[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildStockTransactions> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class StockTransactionsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \DbModel\Base\StockTransactionsQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DbModel\\StockTransactions', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStockTransactionsQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStockTransactionsQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildStockTransactionsQuery) {
            return $criteria;
        }
        $query = new ChildStockTransactionsQuery();
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
     * @return ChildStockTransactions|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StockTransactionsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = StockTransactionsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildStockTransactions A model object, or null if the key is not found
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
            /** @var ChildStockTransactions $obj */
            $obj = new ChildStockTransactions();
            $obj->hydrate($row);
            StockTransactionsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildStockTransactions|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(StockTransactionsTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(StockTransactionsTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(StockTransactionsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(StockTransactionsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(StockTransactionsTableMap::COL_ID, $id, $comparison);

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
     * @see       filterByProducts()
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
                $this->addUsingAlias(StockTransactionsTableMap::COL_PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(StockTransactionsTableMap::COL_PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(StockTransactionsTableMap::COL_PRODUCT_ID, $productId, $comparison);

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
     * @see       filterByWarehousesRelatedByFromWarehouseId()
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
                $this->addUsingAlias(StockTransactionsTableMap::COL_FROM_WAREHOUSE_ID, $fromWarehouseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fromWarehouseId['max'])) {
                $this->addUsingAlias(StockTransactionsTableMap::COL_FROM_WAREHOUSE_ID, $fromWarehouseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(StockTransactionsTableMap::COL_FROM_WAREHOUSE_ID, $fromWarehouseId, $comparison);

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
     * @see       filterByWarehousesRelatedByToWarehouseId()
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
                $this->addUsingAlias(StockTransactionsTableMap::COL_TO_WAREHOUSE_ID, $toWarehouseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($toWarehouseId['max'])) {
                $this->addUsingAlias(StockTransactionsTableMap::COL_TO_WAREHOUSE_ID, $toWarehouseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(StockTransactionsTableMap::COL_TO_WAREHOUSE_ID, $toWarehouseId, $comparison);

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
     * @see       filterByVehicles()
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
                $this->addUsingAlias(StockTransactionsTableMap::COL_VEHICLE_ID, $vehicleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vehicleId['max'])) {
                $this->addUsingAlias(StockTransactionsTableMap::COL_VEHICLE_ID, $vehicleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(StockTransactionsTableMap::COL_VEHICLE_ID, $vehicleId, $comparison);

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
     * @see       filterByUsers()
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
                $this->addUsingAlias(StockTransactionsTableMap::COL_CREATOR_USER_ID, $creatorUserId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($creatorUserId['max'])) {
                $this->addUsingAlias(StockTransactionsTableMap::COL_CREATOR_USER_ID, $creatorUserId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(StockTransactionsTableMap::COL_CREATOR_USER_ID, $creatorUserId, $comparison);

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
                $this->addUsingAlias(StockTransactionsTableMap::COL_AMOUNT, $amount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amount['max'])) {
                $this->addUsingAlias(StockTransactionsTableMap::COL_AMOUNT, $amount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(StockTransactionsTableMap::COL_AMOUNT, $amount, $comparison);

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
                $this->addUsingAlias(StockTransactionsTableMap::COL_CREATED_ON, $createdOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdOn['max'])) {
                $this->addUsingAlias(StockTransactionsTableMap::COL_CREATED_ON, $createdOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(StockTransactionsTableMap::COL_CREATED_ON, $createdOn, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \DbModel\Products object
     *
     * @param \DbModel\Products|ObjectCollection $products The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByProducts($products, ?string $comparison = null)
    {
        if ($products instanceof \DbModel\Products) {
            return $this
                ->addUsingAlias(StockTransactionsTableMap::COL_PRODUCT_ID, $products->getId(), $comparison);
        } elseif ($products instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(StockTransactionsTableMap::COL_PRODUCT_ID, $products->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByProducts() only accepts arguments of type \DbModel\Products or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Products relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinProducts(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Products');

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
            $this->addJoinObject($join, 'Products');
        }

        return $this;
    }

    /**
     * Use the Products relation Products object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DbModel\ProductsQuery A secondary query class using the current class as primary query
     */
    public function useProductsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProducts($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Products', '\DbModel\ProductsQuery');
    }

    /**
     * Use the Products relation Products object
     *
     * @param callable(\DbModel\ProductsQuery):\DbModel\ProductsQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withProductsQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useProductsQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Products table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \DbModel\ProductsQuery The inner query object of the EXISTS statement
     */
    public function useProductsExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \DbModel\ProductsQuery */
        $q = $this->useExistsQuery('Products', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Products table for a NOT EXISTS query.
     *
     * @see useProductsExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \DbModel\ProductsQuery The inner query object of the NOT EXISTS statement
     */
    public function useProductsNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\ProductsQuery */
        $q = $this->useExistsQuery('Products', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Products table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \DbModel\ProductsQuery The inner query object of the IN statement
     */
    public function useInProductsQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \DbModel\ProductsQuery */
        $q = $this->useInQuery('Products', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Products table for a NOT IN query.
     *
     * @see useProductsInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \DbModel\ProductsQuery The inner query object of the NOT IN statement
     */
    public function useNotInProductsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\ProductsQuery */
        $q = $this->useInQuery('Products', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \DbModel\Warehouses object
     *
     * @param \DbModel\Warehouses|ObjectCollection $warehouses The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByWarehousesRelatedByFromWarehouseId($warehouses, ?string $comparison = null)
    {
        if ($warehouses instanceof \DbModel\Warehouses) {
            return $this
                ->addUsingAlias(StockTransactionsTableMap::COL_FROM_WAREHOUSE_ID, $warehouses->getId(), $comparison);
        } elseif ($warehouses instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(StockTransactionsTableMap::COL_FROM_WAREHOUSE_ID, $warehouses->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByWarehousesRelatedByFromWarehouseId() only accepts arguments of type \DbModel\Warehouses or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WarehousesRelatedByFromWarehouseId relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinWarehousesRelatedByFromWarehouseId(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WarehousesRelatedByFromWarehouseId');

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
            $this->addJoinObject($join, 'WarehousesRelatedByFromWarehouseId');
        }

        return $this;
    }

    /**
     * Use the WarehousesRelatedByFromWarehouseId relation Warehouses object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DbModel\WarehousesQuery A secondary query class using the current class as primary query
     */
    public function useWarehousesRelatedByFromWarehouseIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinWarehousesRelatedByFromWarehouseId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WarehousesRelatedByFromWarehouseId', '\DbModel\WarehousesQuery');
    }

    /**
     * Use the WarehousesRelatedByFromWarehouseId relation Warehouses object
     *
     * @param callable(\DbModel\WarehousesQuery):\DbModel\WarehousesQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withWarehousesRelatedByFromWarehouseIdQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useWarehousesRelatedByFromWarehouseIdQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the WarehousesRelatedByFromWarehouseId relation to the Warehouses table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \DbModel\WarehousesQuery The inner query object of the EXISTS statement
     */
    public function useWarehousesRelatedByFromWarehouseIdExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \DbModel\WarehousesQuery */
        $q = $this->useExistsQuery('WarehousesRelatedByFromWarehouseId', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the WarehousesRelatedByFromWarehouseId relation to the Warehouses table for a NOT EXISTS query.
     *
     * @see useWarehousesRelatedByFromWarehouseIdExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \DbModel\WarehousesQuery The inner query object of the NOT EXISTS statement
     */
    public function useWarehousesRelatedByFromWarehouseIdNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\WarehousesQuery */
        $q = $this->useExistsQuery('WarehousesRelatedByFromWarehouseId', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the WarehousesRelatedByFromWarehouseId relation to the Warehouses table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \DbModel\WarehousesQuery The inner query object of the IN statement
     */
    public function useInWarehousesRelatedByFromWarehouseIdQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \DbModel\WarehousesQuery */
        $q = $this->useInQuery('WarehousesRelatedByFromWarehouseId', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the WarehousesRelatedByFromWarehouseId relation to the Warehouses table for a NOT IN query.
     *
     * @see useWarehousesRelatedByFromWarehouseIdInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \DbModel\WarehousesQuery The inner query object of the NOT IN statement
     */
    public function useNotInWarehousesRelatedByFromWarehouseIdQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\WarehousesQuery */
        $q = $this->useInQuery('WarehousesRelatedByFromWarehouseId', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \DbModel\Warehouses object
     *
     * @param \DbModel\Warehouses|ObjectCollection $warehouses The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByWarehousesRelatedByToWarehouseId($warehouses, ?string $comparison = null)
    {
        if ($warehouses instanceof \DbModel\Warehouses) {
            return $this
                ->addUsingAlias(StockTransactionsTableMap::COL_TO_WAREHOUSE_ID, $warehouses->getId(), $comparison);
        } elseif ($warehouses instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(StockTransactionsTableMap::COL_TO_WAREHOUSE_ID, $warehouses->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByWarehousesRelatedByToWarehouseId() only accepts arguments of type \DbModel\Warehouses or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WarehousesRelatedByToWarehouseId relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinWarehousesRelatedByToWarehouseId(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WarehousesRelatedByToWarehouseId');

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
            $this->addJoinObject($join, 'WarehousesRelatedByToWarehouseId');
        }

        return $this;
    }

    /**
     * Use the WarehousesRelatedByToWarehouseId relation Warehouses object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DbModel\WarehousesQuery A secondary query class using the current class as primary query
     */
    public function useWarehousesRelatedByToWarehouseIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinWarehousesRelatedByToWarehouseId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WarehousesRelatedByToWarehouseId', '\DbModel\WarehousesQuery');
    }

    /**
     * Use the WarehousesRelatedByToWarehouseId relation Warehouses object
     *
     * @param callable(\DbModel\WarehousesQuery):\DbModel\WarehousesQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withWarehousesRelatedByToWarehouseIdQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useWarehousesRelatedByToWarehouseIdQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the WarehousesRelatedByToWarehouseId relation to the Warehouses table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \DbModel\WarehousesQuery The inner query object of the EXISTS statement
     */
    public function useWarehousesRelatedByToWarehouseIdExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \DbModel\WarehousesQuery */
        $q = $this->useExistsQuery('WarehousesRelatedByToWarehouseId', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the WarehousesRelatedByToWarehouseId relation to the Warehouses table for a NOT EXISTS query.
     *
     * @see useWarehousesRelatedByToWarehouseIdExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \DbModel\WarehousesQuery The inner query object of the NOT EXISTS statement
     */
    public function useWarehousesRelatedByToWarehouseIdNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\WarehousesQuery */
        $q = $this->useExistsQuery('WarehousesRelatedByToWarehouseId', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the WarehousesRelatedByToWarehouseId relation to the Warehouses table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \DbModel\WarehousesQuery The inner query object of the IN statement
     */
    public function useInWarehousesRelatedByToWarehouseIdQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \DbModel\WarehousesQuery */
        $q = $this->useInQuery('WarehousesRelatedByToWarehouseId', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the WarehousesRelatedByToWarehouseId relation to the Warehouses table for a NOT IN query.
     *
     * @see useWarehousesRelatedByToWarehouseIdInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \DbModel\WarehousesQuery The inner query object of the NOT IN statement
     */
    public function useNotInWarehousesRelatedByToWarehouseIdQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\WarehousesQuery */
        $q = $this->useInQuery('WarehousesRelatedByToWarehouseId', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \DbModel\Vehicles object
     *
     * @param \DbModel\Vehicles|ObjectCollection $vehicles The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByVehicles($vehicles, ?string $comparison = null)
    {
        if ($vehicles instanceof \DbModel\Vehicles) {
            return $this
                ->addUsingAlias(StockTransactionsTableMap::COL_VEHICLE_ID, $vehicles->getId(), $comparison);
        } elseif ($vehicles instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(StockTransactionsTableMap::COL_VEHICLE_ID, $vehicles->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByVehicles() only accepts arguments of type \DbModel\Vehicles or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Vehicles relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinVehicles(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Vehicles');

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
            $this->addJoinObject($join, 'Vehicles');
        }

        return $this;
    }

    /**
     * Use the Vehicles relation Vehicles object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DbModel\VehiclesQuery A secondary query class using the current class as primary query
     */
    public function useVehiclesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinVehicles($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Vehicles', '\DbModel\VehiclesQuery');
    }

    /**
     * Use the Vehicles relation Vehicles object
     *
     * @param callable(\DbModel\VehiclesQuery):\DbModel\VehiclesQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withVehiclesQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useVehiclesQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Vehicles table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \DbModel\VehiclesQuery The inner query object of the EXISTS statement
     */
    public function useVehiclesExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \DbModel\VehiclesQuery */
        $q = $this->useExistsQuery('Vehicles', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Vehicles table for a NOT EXISTS query.
     *
     * @see useVehiclesExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \DbModel\VehiclesQuery The inner query object of the NOT EXISTS statement
     */
    public function useVehiclesNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\VehiclesQuery */
        $q = $this->useExistsQuery('Vehicles', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Vehicles table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \DbModel\VehiclesQuery The inner query object of the IN statement
     */
    public function useInVehiclesQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \DbModel\VehiclesQuery */
        $q = $this->useInQuery('Vehicles', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Vehicles table for a NOT IN query.
     *
     * @see useVehiclesInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \DbModel\VehiclesQuery The inner query object of the NOT IN statement
     */
    public function useNotInVehiclesQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\VehiclesQuery */
        $q = $this->useInQuery('Vehicles', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \DbModel\Users object
     *
     * @param \DbModel\Users|ObjectCollection $users The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByUsers($users, ?string $comparison = null)
    {
        if ($users instanceof \DbModel\Users) {
            return $this
                ->addUsingAlias(StockTransactionsTableMap::COL_CREATOR_USER_ID, $users->getId(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(StockTransactionsTableMap::COL_CREATOR_USER_ID, $users->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByUsers() only accepts arguments of type \DbModel\Users or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Users relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinUsers(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Users');

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
            $this->addJoinObject($join, 'Users');
        }

        return $this;
    }

    /**
     * Use the Users relation Users object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DbModel\UsersQuery A secondary query class using the current class as primary query
     */
    public function useUsersQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUsers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Users', '\DbModel\UsersQuery');
    }

    /**
     * Use the Users relation Users object
     *
     * @param callable(\DbModel\UsersQuery):\DbModel\UsersQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withUsersQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useUsersQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Users table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \DbModel\UsersQuery The inner query object of the EXISTS statement
     */
    public function useUsersExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \DbModel\UsersQuery */
        $q = $this->useExistsQuery('Users', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Users table for a NOT EXISTS query.
     *
     * @see useUsersExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \DbModel\UsersQuery The inner query object of the NOT EXISTS statement
     */
    public function useUsersNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\UsersQuery */
        $q = $this->useExistsQuery('Users', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Users table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \DbModel\UsersQuery The inner query object of the IN statement
     */
    public function useInUsersQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \DbModel\UsersQuery */
        $q = $this->useInQuery('Users', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Users table for a NOT IN query.
     *
     * @see useUsersInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \DbModel\UsersQuery The inner query object of the NOT IN statement
     */
    public function useNotInUsersQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\UsersQuery */
        $q = $this->useInQuery('Users', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildStockTransactions $stockTransactions Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($stockTransactions = null)
    {
        if ($stockTransactions) {
            $this->addUsingAlias(StockTransactionsTableMap::COL_ID, $stockTransactions->getId(), Criteria::NOT_EQUAL);
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
            $con = Propel::getServiceContainer()->getWriteConnection(StockTransactionsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StockTransactionsTableMap::clearInstancePool();
            StockTransactionsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(StockTransactionsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StockTransactionsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            StockTransactionsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StockTransactionsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
