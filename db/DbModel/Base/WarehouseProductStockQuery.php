<?php

namespace DbModel\Base;

use \Exception;
use \PDO;
use DbModel\WarehouseProductStock as ChildWarehouseProductStock;
use DbModel\WarehouseProductStockQuery as ChildWarehouseProductStockQuery;
use DbModel\Map\WarehouseProductStockTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `warehouse_product_stock` table.
 *
 * @method     ChildWarehouseProductStockQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildWarehouseProductStockQuery orderByWarehouseId($order = Criteria::ASC) Order by the warehouse_id column
 * @method     ChildWarehouseProductStockQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildWarehouseProductStockQuery orderByAmount($order = Criteria::ASC) Order by the amount column
 * @method     ChildWarehouseProductStockQuery orderByCreatedOn($order = Criteria::ASC) Order by the created_on column
 *
 * @method     ChildWarehouseProductStockQuery groupById() Group by the id column
 * @method     ChildWarehouseProductStockQuery groupByWarehouseId() Group by the warehouse_id column
 * @method     ChildWarehouseProductStockQuery groupByProductId() Group by the product_id column
 * @method     ChildWarehouseProductStockQuery groupByAmount() Group by the amount column
 * @method     ChildWarehouseProductStockQuery groupByCreatedOn() Group by the created_on column
 *
 * @method     ChildWarehouseProductStockQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildWarehouseProductStockQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildWarehouseProductStockQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildWarehouseProductStockQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildWarehouseProductStockQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildWarehouseProductStockQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildWarehouseProductStockQuery leftJoinWarehouses($relationAlias = null) Adds a LEFT JOIN clause to the query using the Warehouses relation
 * @method     ChildWarehouseProductStockQuery rightJoinWarehouses($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Warehouses relation
 * @method     ChildWarehouseProductStockQuery innerJoinWarehouses($relationAlias = null) Adds a INNER JOIN clause to the query using the Warehouses relation
 *
 * @method     ChildWarehouseProductStockQuery joinWithWarehouses($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Warehouses relation
 *
 * @method     ChildWarehouseProductStockQuery leftJoinWithWarehouses() Adds a LEFT JOIN clause and with to the query using the Warehouses relation
 * @method     ChildWarehouseProductStockQuery rightJoinWithWarehouses() Adds a RIGHT JOIN clause and with to the query using the Warehouses relation
 * @method     ChildWarehouseProductStockQuery innerJoinWithWarehouses() Adds a INNER JOIN clause and with to the query using the Warehouses relation
 *
 * @method     ChildWarehouseProductStockQuery leftJoinProducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the Products relation
 * @method     ChildWarehouseProductStockQuery rightJoinProducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Products relation
 * @method     ChildWarehouseProductStockQuery innerJoinProducts($relationAlias = null) Adds a INNER JOIN clause to the query using the Products relation
 *
 * @method     ChildWarehouseProductStockQuery joinWithProducts($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Products relation
 *
 * @method     ChildWarehouseProductStockQuery leftJoinWithProducts() Adds a LEFT JOIN clause and with to the query using the Products relation
 * @method     ChildWarehouseProductStockQuery rightJoinWithProducts() Adds a RIGHT JOIN clause and with to the query using the Products relation
 * @method     ChildWarehouseProductStockQuery innerJoinWithProducts() Adds a INNER JOIN clause and with to the query using the Products relation
 *
 * @method     \DbModel\WarehousesQuery|\DbModel\ProductsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildWarehouseProductStock|null findOne(?ConnectionInterface $con = null) Return the first ChildWarehouseProductStock matching the query
 * @method     ChildWarehouseProductStock findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildWarehouseProductStock matching the query, or a new ChildWarehouseProductStock object populated from the query conditions when no match is found
 *
 * @method     ChildWarehouseProductStock|null findOneById(int $id) Return the first ChildWarehouseProductStock filtered by the id column
 * @method     ChildWarehouseProductStock|null findOneByWarehouseId(int $warehouse_id) Return the first ChildWarehouseProductStock filtered by the warehouse_id column
 * @method     ChildWarehouseProductStock|null findOneByProductId(int $product_id) Return the first ChildWarehouseProductStock filtered by the product_id column
 * @method     ChildWarehouseProductStock|null findOneByAmount(int $amount) Return the first ChildWarehouseProductStock filtered by the amount column
 * @method     ChildWarehouseProductStock|null findOneByCreatedOn(string $created_on) Return the first ChildWarehouseProductStock filtered by the created_on column
 *
 * @method     ChildWarehouseProductStock requirePk($key, ?ConnectionInterface $con = null) Return the ChildWarehouseProductStock by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWarehouseProductStock requireOne(?ConnectionInterface $con = null) Return the first ChildWarehouseProductStock matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWarehouseProductStock requireOneById(int $id) Return the first ChildWarehouseProductStock filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWarehouseProductStock requireOneByWarehouseId(int $warehouse_id) Return the first ChildWarehouseProductStock filtered by the warehouse_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWarehouseProductStock requireOneByProductId(int $product_id) Return the first ChildWarehouseProductStock filtered by the product_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWarehouseProductStock requireOneByAmount(int $amount) Return the first ChildWarehouseProductStock filtered by the amount column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWarehouseProductStock requireOneByCreatedOn(string $created_on) Return the first ChildWarehouseProductStock filtered by the created_on column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWarehouseProductStock[]|Collection find(?ConnectionInterface $con = null) Return ChildWarehouseProductStock objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildWarehouseProductStock> find(?ConnectionInterface $con = null) Return ChildWarehouseProductStock objects based on current ModelCriteria
 *
 * @method     ChildWarehouseProductStock[]|Collection findById(int|array<int> $id) Return ChildWarehouseProductStock objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildWarehouseProductStock> findById(int|array<int> $id) Return ChildWarehouseProductStock objects filtered by the id column
 * @method     ChildWarehouseProductStock[]|Collection findByWarehouseId(int|array<int> $warehouse_id) Return ChildWarehouseProductStock objects filtered by the warehouse_id column
 * @psalm-method Collection&\Traversable<ChildWarehouseProductStock> findByWarehouseId(int|array<int> $warehouse_id) Return ChildWarehouseProductStock objects filtered by the warehouse_id column
 * @method     ChildWarehouseProductStock[]|Collection findByProductId(int|array<int> $product_id) Return ChildWarehouseProductStock objects filtered by the product_id column
 * @psalm-method Collection&\Traversable<ChildWarehouseProductStock> findByProductId(int|array<int> $product_id) Return ChildWarehouseProductStock objects filtered by the product_id column
 * @method     ChildWarehouseProductStock[]|Collection findByAmount(int|array<int> $amount) Return ChildWarehouseProductStock objects filtered by the amount column
 * @psalm-method Collection&\Traversable<ChildWarehouseProductStock> findByAmount(int|array<int> $amount) Return ChildWarehouseProductStock objects filtered by the amount column
 * @method     ChildWarehouseProductStock[]|Collection findByCreatedOn(string|array<string> $created_on) Return ChildWarehouseProductStock objects filtered by the created_on column
 * @psalm-method Collection&\Traversable<ChildWarehouseProductStock> findByCreatedOn(string|array<string> $created_on) Return ChildWarehouseProductStock objects filtered by the created_on column
 *
 * @method     ChildWarehouseProductStock[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildWarehouseProductStock> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class WarehouseProductStockQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \DbModel\Base\WarehouseProductStockQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DbModel\\WarehouseProductStock', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildWarehouseProductStockQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildWarehouseProductStockQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildWarehouseProductStockQuery) {
            return $criteria;
        }
        $query = new ChildWarehouseProductStockQuery();
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
     * @return ChildWarehouseProductStock|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WarehouseProductStockTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = WarehouseProductStockTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildWarehouseProductStock A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, warehouse_id, product_id, amount, created_on FROM warehouse_product_stock WHERE id = :p0';
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
            /** @var ChildWarehouseProductStock $obj */
            $obj = new ChildWarehouseProductStock();
            $obj->hydrate($row);
            WarehouseProductStockTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildWarehouseProductStock|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(WarehouseProductStockTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(WarehouseProductStockTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(WarehouseProductStockTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(WarehouseProductStockTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(WarehouseProductStockTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the warehouse_id column
     *
     * Example usage:
     * <code>
     * $query->filterByWarehouseId(1234); // WHERE warehouse_id = 1234
     * $query->filterByWarehouseId(array(12, 34)); // WHERE warehouse_id IN (12, 34)
     * $query->filterByWarehouseId(array('min' => 12)); // WHERE warehouse_id > 12
     * </code>
     *
     * @see       filterByWarehouses()
     *
     * @param mixed $warehouseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByWarehouseId($warehouseId = null, ?string $comparison = null)
    {
        if (is_array($warehouseId)) {
            $useMinMax = false;
            if (isset($warehouseId['min'])) {
                $this->addUsingAlias(WarehouseProductStockTableMap::COL_WAREHOUSE_ID, $warehouseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($warehouseId['max'])) {
                $this->addUsingAlias(WarehouseProductStockTableMap::COL_WAREHOUSE_ID, $warehouseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(WarehouseProductStockTableMap::COL_WAREHOUSE_ID, $warehouseId, $comparison);

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
                $this->addUsingAlias(WarehouseProductStockTableMap::COL_PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(WarehouseProductStockTableMap::COL_PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(WarehouseProductStockTableMap::COL_PRODUCT_ID, $productId, $comparison);

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
                $this->addUsingAlias(WarehouseProductStockTableMap::COL_AMOUNT, $amount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amount['max'])) {
                $this->addUsingAlias(WarehouseProductStockTableMap::COL_AMOUNT, $amount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(WarehouseProductStockTableMap::COL_AMOUNT, $amount, $comparison);

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
                $this->addUsingAlias(WarehouseProductStockTableMap::COL_CREATED_ON, $createdOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdOn['max'])) {
                $this->addUsingAlias(WarehouseProductStockTableMap::COL_CREATED_ON, $createdOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(WarehouseProductStockTableMap::COL_CREATED_ON, $createdOn, $comparison);

        return $this;
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
    public function filterByWarehouses($warehouses, ?string $comparison = null)
    {
        if ($warehouses instanceof \DbModel\Warehouses) {
            return $this
                ->addUsingAlias(WarehouseProductStockTableMap::COL_WAREHOUSE_ID, $warehouses->getId(), $comparison);
        } elseif ($warehouses instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(WarehouseProductStockTableMap::COL_WAREHOUSE_ID, $warehouses->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByWarehouses() only accepts arguments of type \DbModel\Warehouses or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Warehouses relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinWarehouses(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Warehouses');

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
            $this->addJoinObject($join, 'Warehouses');
        }

        return $this;
    }

    /**
     * Use the Warehouses relation Warehouses object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DbModel\WarehousesQuery A secondary query class using the current class as primary query
     */
    public function useWarehousesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinWarehouses($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Warehouses', '\DbModel\WarehousesQuery');
    }

    /**
     * Use the Warehouses relation Warehouses object
     *
     * @param callable(\DbModel\WarehousesQuery):\DbModel\WarehousesQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withWarehousesQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useWarehousesQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Warehouses table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \DbModel\WarehousesQuery The inner query object of the EXISTS statement
     */
    public function useWarehousesExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \DbModel\WarehousesQuery */
        $q = $this->useExistsQuery('Warehouses', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Warehouses table for a NOT EXISTS query.
     *
     * @see useWarehousesExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \DbModel\WarehousesQuery The inner query object of the NOT EXISTS statement
     */
    public function useWarehousesNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\WarehousesQuery */
        $q = $this->useExistsQuery('Warehouses', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Warehouses table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \DbModel\WarehousesQuery The inner query object of the IN statement
     */
    public function useInWarehousesQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \DbModel\WarehousesQuery */
        $q = $this->useInQuery('Warehouses', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Warehouses table for a NOT IN query.
     *
     * @see useWarehousesInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \DbModel\WarehousesQuery The inner query object of the NOT IN statement
     */
    public function useNotInWarehousesQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\WarehousesQuery */
        $q = $this->useInQuery('Warehouses', $modelAlias, $queryClass, 'NOT IN');
        return $q;
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
                ->addUsingAlias(WarehouseProductStockTableMap::COL_PRODUCT_ID, $products->getId(), $comparison);
        } elseif ($products instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(WarehouseProductStockTableMap::COL_PRODUCT_ID, $products->toKeyValue('PrimaryKey', 'Id'), $comparison);

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
     * Exclude object from result
     *
     * @param ChildWarehouseProductStock $warehouseProductStock Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($warehouseProductStock = null)
    {
        if ($warehouseProductStock) {
            $this->addUsingAlias(WarehouseProductStockTableMap::COL_ID, $warehouseProductStock->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the warehouse_product_stock table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WarehouseProductStockTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            WarehouseProductStockTableMap::clearInstancePool();
            WarehouseProductStockTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(WarehouseProductStockTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(WarehouseProductStockTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            WarehouseProductStockTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            WarehouseProductStockTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
