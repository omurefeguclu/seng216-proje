<?php

namespace DbModel\Base;

use \Exception;
use \PDO;
use DbModel\Products as ChildProducts;
use DbModel\ProductsQuery as ChildProductsQuery;
use DbModel\Map\ProductsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `products` table.
 *
 * @method     ChildProductsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildProductsQuery orderByName($order = Criteria::ASC) Order by the NAME column
 * @method     ChildProductsQuery orderByCreatedOn($order = Criteria::ASC) Order by the created_on column
 *
 * @method     ChildProductsQuery groupById() Group by the id column
 * @method     ChildProductsQuery groupByName() Group by the NAME column
 * @method     ChildProductsQuery groupByCreatedOn() Group by the created_on column
 *
 * @method     ChildProductsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProductsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProductsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProductsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildProductsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildProductsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildProductsQuery leftJoinStockTransactions($relationAlias = null) Adds a LEFT JOIN clause to the query using the StockTransactions relation
 * @method     ChildProductsQuery rightJoinStockTransactions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StockTransactions relation
 * @method     ChildProductsQuery innerJoinStockTransactions($relationAlias = null) Adds a INNER JOIN clause to the query using the StockTransactions relation
 *
 * @method     ChildProductsQuery joinWithStockTransactions($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the StockTransactions relation
 *
 * @method     ChildProductsQuery leftJoinWithStockTransactions() Adds a LEFT JOIN clause and with to the query using the StockTransactions relation
 * @method     ChildProductsQuery rightJoinWithStockTransactions() Adds a RIGHT JOIN clause and with to the query using the StockTransactions relation
 * @method     ChildProductsQuery innerJoinWithStockTransactions() Adds a INNER JOIN clause and with to the query using the StockTransactions relation
 *
 * @method     ChildProductsQuery leftJoinWarehouseProductStock($relationAlias = null) Adds a LEFT JOIN clause to the query using the WarehouseProductStock relation
 * @method     ChildProductsQuery rightJoinWarehouseProductStock($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WarehouseProductStock relation
 * @method     ChildProductsQuery innerJoinWarehouseProductStock($relationAlias = null) Adds a INNER JOIN clause to the query using the WarehouseProductStock relation
 *
 * @method     ChildProductsQuery joinWithWarehouseProductStock($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WarehouseProductStock relation
 *
 * @method     ChildProductsQuery leftJoinWithWarehouseProductStock() Adds a LEFT JOIN clause and with to the query using the WarehouseProductStock relation
 * @method     ChildProductsQuery rightJoinWithWarehouseProductStock() Adds a RIGHT JOIN clause and with to the query using the WarehouseProductStock relation
 * @method     ChildProductsQuery innerJoinWithWarehouseProductStock() Adds a INNER JOIN clause and with to the query using the WarehouseProductStock relation
 *
 * @method     ChildProductsQuery leftJoinWarehouseProductStockLog($relationAlias = null) Adds a LEFT JOIN clause to the query using the WarehouseProductStockLog relation
 * @method     ChildProductsQuery rightJoinWarehouseProductStockLog($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WarehouseProductStockLog relation
 * @method     ChildProductsQuery innerJoinWarehouseProductStockLog($relationAlias = null) Adds a INNER JOIN clause to the query using the WarehouseProductStockLog relation
 *
 * @method     ChildProductsQuery joinWithWarehouseProductStockLog($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WarehouseProductStockLog relation
 *
 * @method     ChildProductsQuery leftJoinWithWarehouseProductStockLog() Adds a LEFT JOIN clause and with to the query using the WarehouseProductStockLog relation
 * @method     ChildProductsQuery rightJoinWithWarehouseProductStockLog() Adds a RIGHT JOIN clause and with to the query using the WarehouseProductStockLog relation
 * @method     ChildProductsQuery innerJoinWithWarehouseProductStockLog() Adds a INNER JOIN clause and with to the query using the WarehouseProductStockLog relation
 *
 * @method     \DbModel\StockTransactionsQuery|\DbModel\WarehouseProductStockQuery|\DbModel\WarehouseProductStockLogQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildProducts|null findOne(?ConnectionInterface $con = null) Return the first ChildProducts matching the query
 * @method     ChildProducts findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildProducts matching the query, or a new ChildProducts object populated from the query conditions when no match is found
 *
 * @method     ChildProducts|null findOneById(int $id) Return the first ChildProducts filtered by the id column
 * @method     ChildProducts|null findOneByName(string $NAME) Return the first ChildProducts filtered by the NAME column
 * @method     ChildProducts|null findOneByCreatedOn(string $created_on) Return the first ChildProducts filtered by the created_on column
 *
 * @method     ChildProducts requirePk($key, ?ConnectionInterface $con = null) Return the ChildProducts by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProducts requireOne(?ConnectionInterface $con = null) Return the first ChildProducts matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProducts requireOneById(int $id) Return the first ChildProducts filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProducts requireOneByName(string $NAME) Return the first ChildProducts filtered by the NAME column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProducts requireOneByCreatedOn(string $created_on) Return the first ChildProducts filtered by the created_on column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProducts[]|Collection find(?ConnectionInterface $con = null) Return ChildProducts objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildProducts> find(?ConnectionInterface $con = null) Return ChildProducts objects based on current ModelCriteria
 *
 * @method     ChildProducts[]|Collection findById(int|array<int> $id) Return ChildProducts objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildProducts> findById(int|array<int> $id) Return ChildProducts objects filtered by the id column
 * @method     ChildProducts[]|Collection findByName(string|array<string> $NAME) Return ChildProducts objects filtered by the NAME column
 * @psalm-method Collection&\Traversable<ChildProducts> findByName(string|array<string> $NAME) Return ChildProducts objects filtered by the NAME column
 * @method     ChildProducts[]|Collection findByCreatedOn(string|array<string> $created_on) Return ChildProducts objects filtered by the created_on column
 * @psalm-method Collection&\Traversable<ChildProducts> findByCreatedOn(string|array<string> $created_on) Return ChildProducts objects filtered by the created_on column
 *
 * @method     ChildProducts[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildProducts> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class ProductsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \DbModel\Base\ProductsQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DbModel\\Products', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProductsQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProductsQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildProductsQuery) {
            return $criteria;
        }
        $query = new ChildProductsQuery();
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
     * @return ChildProducts|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProductsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ProductsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildProducts A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, NAME, created_on FROM products WHERE id = :p0';
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
            /** @var ChildProducts $obj */
            $obj = new ChildProducts();
            $obj->hydrate($row);
            ProductsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildProducts|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(ProductsTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(ProductsTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(ProductsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProductsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(ProductsTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the NAME column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE NAME = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE NAME LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE NAME IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(ProductsTableMap::COL_NAME, $name, $comparison);

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
                $this->addUsingAlias(ProductsTableMap::COL_CREATED_ON, $createdOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdOn['max'])) {
                $this->addUsingAlias(ProductsTableMap::COL_CREATED_ON, $createdOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(ProductsTableMap::COL_CREATED_ON, $createdOn, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \DbModel\StockTransactions object
     *
     * @param \DbModel\StockTransactions|ObjectCollection $stockTransactions the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByStockTransactions($stockTransactions, ?string $comparison = null)
    {
        if ($stockTransactions instanceof \DbModel\StockTransactions) {
            $this
                ->addUsingAlias(ProductsTableMap::COL_ID, $stockTransactions->getProductId(), $comparison);

            return $this;
        } elseif ($stockTransactions instanceof ObjectCollection) {
            $this
                ->useStockTransactionsQuery()
                ->filterByPrimaryKeys($stockTransactions->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByStockTransactions() only accepts arguments of type \DbModel\StockTransactions or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StockTransactions relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinStockTransactions(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StockTransactions');

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
            $this->addJoinObject($join, 'StockTransactions');
        }

        return $this;
    }

    /**
     * Use the StockTransactions relation StockTransactions object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DbModel\StockTransactionsQuery A secondary query class using the current class as primary query
     */
    public function useStockTransactionsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStockTransactions($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StockTransactions', '\DbModel\StockTransactionsQuery');
    }

    /**
     * Use the StockTransactions relation StockTransactions object
     *
     * @param callable(\DbModel\StockTransactionsQuery):\DbModel\StockTransactionsQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withStockTransactionsQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useStockTransactionsQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to StockTransactions table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \DbModel\StockTransactionsQuery The inner query object of the EXISTS statement
     */
    public function useStockTransactionsExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \DbModel\StockTransactionsQuery */
        $q = $this->useExistsQuery('StockTransactions', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to StockTransactions table for a NOT EXISTS query.
     *
     * @see useStockTransactionsExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \DbModel\StockTransactionsQuery The inner query object of the NOT EXISTS statement
     */
    public function useStockTransactionsNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\StockTransactionsQuery */
        $q = $this->useExistsQuery('StockTransactions', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to StockTransactions table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \DbModel\StockTransactionsQuery The inner query object of the IN statement
     */
    public function useInStockTransactionsQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \DbModel\StockTransactionsQuery */
        $q = $this->useInQuery('StockTransactions', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to StockTransactions table for a NOT IN query.
     *
     * @see useStockTransactionsInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \DbModel\StockTransactionsQuery The inner query object of the NOT IN statement
     */
    public function useNotInStockTransactionsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\StockTransactionsQuery */
        $q = $this->useInQuery('StockTransactions', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \DbModel\WarehouseProductStock object
     *
     * @param \DbModel\WarehouseProductStock|ObjectCollection $warehouseProductStock the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByWarehouseProductStock($warehouseProductStock, ?string $comparison = null)
    {
        if ($warehouseProductStock instanceof \DbModel\WarehouseProductStock) {
            $this
                ->addUsingAlias(ProductsTableMap::COL_ID, $warehouseProductStock->getProductId(), $comparison);

            return $this;
        } elseif ($warehouseProductStock instanceof ObjectCollection) {
            $this
                ->useWarehouseProductStockQuery()
                ->filterByPrimaryKeys($warehouseProductStock->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByWarehouseProductStock() only accepts arguments of type \DbModel\WarehouseProductStock or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WarehouseProductStock relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinWarehouseProductStock(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WarehouseProductStock');

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
            $this->addJoinObject($join, 'WarehouseProductStock');
        }

        return $this;
    }

    /**
     * Use the WarehouseProductStock relation WarehouseProductStock object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DbModel\WarehouseProductStockQuery A secondary query class using the current class as primary query
     */
    public function useWarehouseProductStockQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinWarehouseProductStock($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WarehouseProductStock', '\DbModel\WarehouseProductStockQuery');
    }

    /**
     * Use the WarehouseProductStock relation WarehouseProductStock object
     *
     * @param callable(\DbModel\WarehouseProductStockQuery):\DbModel\WarehouseProductStockQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withWarehouseProductStockQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useWarehouseProductStockQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to WarehouseProductStock table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \DbModel\WarehouseProductStockQuery The inner query object of the EXISTS statement
     */
    public function useWarehouseProductStockExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \DbModel\WarehouseProductStockQuery */
        $q = $this->useExistsQuery('WarehouseProductStock', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to WarehouseProductStock table for a NOT EXISTS query.
     *
     * @see useWarehouseProductStockExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \DbModel\WarehouseProductStockQuery The inner query object of the NOT EXISTS statement
     */
    public function useWarehouseProductStockNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\WarehouseProductStockQuery */
        $q = $this->useExistsQuery('WarehouseProductStock', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to WarehouseProductStock table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \DbModel\WarehouseProductStockQuery The inner query object of the IN statement
     */
    public function useInWarehouseProductStockQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \DbModel\WarehouseProductStockQuery */
        $q = $this->useInQuery('WarehouseProductStock', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to WarehouseProductStock table for a NOT IN query.
     *
     * @see useWarehouseProductStockInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \DbModel\WarehouseProductStockQuery The inner query object of the NOT IN statement
     */
    public function useNotInWarehouseProductStockQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\WarehouseProductStockQuery */
        $q = $this->useInQuery('WarehouseProductStock', $modelAlias, $queryClass, 'NOT IN');
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
                ->addUsingAlias(ProductsTableMap::COL_ID, $warehouseProductStockLog->getProductId(), $comparison);

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
    public function joinWarehouseProductStockLog(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
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
    public function useWarehouseProductStockLogQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
        ?string $joinType = Criteria::INNER_JOIN
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
     * @param ChildProducts $products Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($products = null)
    {
        if ($products) {
            $this->addUsingAlias(ProductsTableMap::COL_ID, $products->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the products table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProductsTableMap::clearInstancePool();
            ProductsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ProductsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProductsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ProductsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ProductsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
