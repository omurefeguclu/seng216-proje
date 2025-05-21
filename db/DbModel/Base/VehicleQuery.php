<?php

namespace DbModel\Base;

use \Exception;
use \PDO;
use DbModel\Vehicle as ChildVehicle;
use DbModel\VehicleQuery as ChildVehicleQuery;
use DbModel\Map\VehicleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `vehicles` table.
 *
 * @method     ChildVehicleQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildVehicleQuery orderByPlateNumber($order = Criteria::ASC) Order by the plate_number column
 * @method     ChildVehicleQuery orderByCreatedOn($order = Criteria::ASC) Order by the created_on column
 *
 * @method     ChildVehicleQuery groupById() Group by the id column
 * @method     ChildVehicleQuery groupByPlateNumber() Group by the plate_number column
 * @method     ChildVehicleQuery groupByCreatedOn() Group by the created_on column
 *
 * @method     ChildVehicleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildVehicleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildVehicleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildVehicleQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildVehicleQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildVehicleQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildVehicleQuery leftJoinStockTransaction($relationAlias = null) Adds a LEFT JOIN clause to the query using the StockTransaction relation
 * @method     ChildVehicleQuery rightJoinStockTransaction($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StockTransaction relation
 * @method     ChildVehicleQuery innerJoinStockTransaction($relationAlias = null) Adds a INNER JOIN clause to the query using the StockTransaction relation
 *
 * @method     ChildVehicleQuery joinWithStockTransaction($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the StockTransaction relation
 *
 * @method     ChildVehicleQuery leftJoinWithStockTransaction() Adds a LEFT JOIN clause and with to the query using the StockTransaction relation
 * @method     ChildVehicleQuery rightJoinWithStockTransaction() Adds a RIGHT JOIN clause and with to the query using the StockTransaction relation
 * @method     ChildVehicleQuery innerJoinWithStockTransaction() Adds a INNER JOIN clause and with to the query using the StockTransaction relation
 *
 * @method     \DbModel\StockTransactionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildVehicle|null findOne(?ConnectionInterface $con = null) Return the first ChildVehicle matching the query
 * @method     ChildVehicle findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildVehicle matching the query, or a new ChildVehicle object populated from the query conditions when no match is found
 *
 * @method     ChildVehicle|null findOneById(int $id) Return the first ChildVehicle filtered by the id column
 * @method     ChildVehicle|null findOneByPlateNumber(string $plate_number) Return the first ChildVehicle filtered by the plate_number column
 * @method     ChildVehicle|null findOneByCreatedOn(string $created_on) Return the first ChildVehicle filtered by the created_on column
 *
 * @method     ChildVehicle requirePk($key, ?ConnectionInterface $con = null) Return the ChildVehicle by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVehicle requireOne(?ConnectionInterface $con = null) Return the first ChildVehicle matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVehicle requireOneById(int $id) Return the first ChildVehicle filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVehicle requireOneByPlateNumber(string $plate_number) Return the first ChildVehicle filtered by the plate_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVehicle requireOneByCreatedOn(string $created_on) Return the first ChildVehicle filtered by the created_on column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVehicle[]|Collection find(?ConnectionInterface $con = null) Return ChildVehicle objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildVehicle> find(?ConnectionInterface $con = null) Return ChildVehicle objects based on current ModelCriteria
 *
 * @method     ChildVehicle[]|Collection findById(int|array<int> $id) Return ChildVehicle objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildVehicle> findById(int|array<int> $id) Return ChildVehicle objects filtered by the id column
 * @method     ChildVehicle[]|Collection findByPlateNumber(string|array<string> $plate_number) Return ChildVehicle objects filtered by the plate_number column
 * @psalm-method Collection&\Traversable<ChildVehicle> findByPlateNumber(string|array<string> $plate_number) Return ChildVehicle objects filtered by the plate_number column
 * @method     ChildVehicle[]|Collection findByCreatedOn(string|array<string> $created_on) Return ChildVehicle objects filtered by the created_on column
 * @psalm-method Collection&\Traversable<ChildVehicle> findByCreatedOn(string|array<string> $created_on) Return ChildVehicle objects filtered by the created_on column
 *
 * @method     ChildVehicle[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildVehicle> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class VehicleQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \DbModel\Base\VehicleQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DbModel\\Vehicle', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVehicleQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildVehicleQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildVehicleQuery) {
            return $criteria;
        }
        $query = new ChildVehicleQuery();
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
     * @return ChildVehicle|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VehicleTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = VehicleTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildVehicle A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, plate_number, created_on FROM vehicles WHERE id = :p0';
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
            /** @var ChildVehicle $obj */
            $obj = new ChildVehicle();
            $obj->hydrate($row);
            VehicleTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildVehicle|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(VehicleTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(VehicleTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(VehicleTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(VehicleTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(VehicleTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plate_number column
     *
     * Example usage:
     * <code>
     * $query->filterByPlateNumber('fooValue');   // WHERE plate_number = 'fooValue'
     * $query->filterByPlateNumber('%fooValue%', Criteria::LIKE); // WHERE plate_number LIKE '%fooValue%'
     * $query->filterByPlateNumber(['foo', 'bar']); // WHERE plate_number IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $plateNumber The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPlateNumber($plateNumber = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($plateNumber)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(VehicleTableMap::COL_PLATE_NUMBER, $plateNumber, $comparison);

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
                $this->addUsingAlias(VehicleTableMap::COL_CREATED_ON, $createdOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdOn['max'])) {
                $this->addUsingAlias(VehicleTableMap::COL_CREATED_ON, $createdOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(VehicleTableMap::COL_CREATED_ON, $createdOn, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \DbModel\StockTransaction object
     *
     * @param \DbModel\StockTransaction|ObjectCollection $stockTransaction the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByStockTransaction($stockTransaction, ?string $comparison = null)
    {
        if ($stockTransaction instanceof \DbModel\StockTransaction) {
            $this
                ->addUsingAlias(VehicleTableMap::COL_ID, $stockTransaction->getVehicleId(), $comparison);

            return $this;
        } elseif ($stockTransaction instanceof ObjectCollection) {
            $this
                ->useStockTransactionQuery()
                ->filterByPrimaryKeys($stockTransaction->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByStockTransaction() only accepts arguments of type \DbModel\StockTransaction or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StockTransaction relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinStockTransaction(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StockTransaction');

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
            $this->addJoinObject($join, 'StockTransaction');
        }

        return $this;
    }

    /**
     * Use the StockTransaction relation StockTransaction object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DbModel\StockTransactionQuery A secondary query class using the current class as primary query
     */
    public function useStockTransactionQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStockTransaction($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StockTransaction', '\DbModel\StockTransactionQuery');
    }

    /**
     * Use the StockTransaction relation StockTransaction object
     *
     * @param callable(\DbModel\StockTransactionQuery):\DbModel\StockTransactionQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withStockTransactionQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useStockTransactionQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to StockTransaction table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \DbModel\StockTransactionQuery The inner query object of the EXISTS statement
     */
    public function useStockTransactionExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \DbModel\StockTransactionQuery */
        $q = $this->useExistsQuery('StockTransaction', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to StockTransaction table for a NOT EXISTS query.
     *
     * @see useStockTransactionExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \DbModel\StockTransactionQuery The inner query object of the NOT EXISTS statement
     */
    public function useStockTransactionNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\StockTransactionQuery */
        $q = $this->useExistsQuery('StockTransaction', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to StockTransaction table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \DbModel\StockTransactionQuery The inner query object of the IN statement
     */
    public function useInStockTransactionQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \DbModel\StockTransactionQuery */
        $q = $this->useInQuery('StockTransaction', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to StockTransaction table for a NOT IN query.
     *
     * @see useStockTransactionInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \DbModel\StockTransactionQuery The inner query object of the NOT IN statement
     */
    public function useNotInStockTransactionQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \DbModel\StockTransactionQuery */
        $q = $this->useInQuery('StockTransaction', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildVehicle $vehicle Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($vehicle = null)
    {
        if ($vehicle) {
            $this->addUsingAlias(VehicleTableMap::COL_ID, $vehicle->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the vehicles table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VehicleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VehicleTableMap::clearInstancePool();
            VehicleTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(VehicleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VehicleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VehicleTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            VehicleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
