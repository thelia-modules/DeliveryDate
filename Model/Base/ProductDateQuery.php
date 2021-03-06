<?php

namespace DeliveryDate\Model\Base;

use \Exception;
use \PDO;
use DeliveryDate\Model\ProductDate as ChildProductDate;
use DeliveryDate\Model\ProductDateQuery as ChildProductDateQuery;
use DeliveryDate\Model\Map\ProductDateTableMap;
use DeliveryDate\Model\Thelia\Model\ProductSaleElements;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'product_date' table.
 *
 *
 *
 * @method     ChildProductDateQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildProductDateQuery orderByDeliveryTimeMin($order = Criteria::ASC) Order by the delivery_time_min column
 * @method     ChildProductDateQuery orderByDeliveryTimeMax($order = Criteria::ASC) Order by the delivery_time_max column
 * @method     ChildProductDateQuery orderByRestockTimeMin($order = Criteria::ASC) Order by the restock_time_min column
 * @method     ChildProductDateQuery orderByRestockTimeMax($order = Criteria::ASC) Order by the restock_time_max column
 *
 * @method     ChildProductDateQuery groupById() Group by the id column
 * @method     ChildProductDateQuery groupByDeliveryTimeMin() Group by the delivery_time_min column
 * @method     ChildProductDateQuery groupByDeliveryTimeMax() Group by the delivery_time_max column
 * @method     ChildProductDateQuery groupByRestockTimeMin() Group by the restock_time_min column
 * @method     ChildProductDateQuery groupByRestockTimeMax() Group by the restock_time_max column
 *
 * @method     ChildProductDateQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProductDateQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProductDateQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProductDateQuery leftJoinProductSaleElements($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductSaleElements relation
 * @method     ChildProductDateQuery rightJoinProductSaleElements($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductSaleElements relation
 * @method     ChildProductDateQuery innerJoinProductSaleElements($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductSaleElements relation
 *
 * @method     ChildProductDate findOne(ConnectionInterface $con = null) Return the first ChildProductDate matching the query
 * @method     ChildProductDate findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProductDate matching the query, or a new ChildProductDate object populated from the query conditions when no match is found
 *
 * @method     ChildProductDate findOneById(int $id) Return the first ChildProductDate filtered by the id column
 * @method     ChildProductDate findOneByDeliveryTimeMin(int $delivery_time_min) Return the first ChildProductDate filtered by the delivery_time_min column
 * @method     ChildProductDate findOneByDeliveryTimeMax(int $delivery_time_max) Return the first ChildProductDate filtered by the delivery_time_max column
 * @method     ChildProductDate findOneByRestockTimeMin(int $restock_time_min) Return the first ChildProductDate filtered by the restock_time_min column
 * @method     ChildProductDate findOneByRestockTimeMax(int $restock_time_max) Return the first ChildProductDate filtered by the restock_time_max column
 *
 * @method     array findById(int $id) Return ChildProductDate objects filtered by the id column
 * @method     array findByDeliveryTimeMin(int $delivery_time_min) Return ChildProductDate objects filtered by the delivery_time_min column
 * @method     array findByDeliveryTimeMax(int $delivery_time_max) Return ChildProductDate objects filtered by the delivery_time_max column
 * @method     array findByRestockTimeMin(int $restock_time_min) Return ChildProductDate objects filtered by the restock_time_min column
 * @method     array findByRestockTimeMax(int $restock_time_max) Return ChildProductDate objects filtered by the restock_time_max column
 *
 */
abstract class ProductDateQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \DeliveryDate\Model\Base\ProductDateQuery object.
     *
     * @param string $dbName     The database name
     * @param string $modelName  The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\DeliveryDate\\Model\\ProductDate', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProductDateQuery object.
     *
     * @param string   $modelAlias The alias of a model in the query
     * @param Criteria $criteria   Optional Criteria to build the query from
     *
     * @return ChildProductDateQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \DeliveryDate\Model\ProductDateQuery) {
            return $criteria;
        }
        $query = new \DeliveryDate\Model\ProductDateQuery();
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
     * @param mixed               $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildProductDate|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProductDateTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProductDateTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param mixed               $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @return ChildProductDate A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, DELIVERY_TIME_MIN, DELIVERY_TIME_MAX, RESTOCK_TIME_MIN, RESTOCK_TIME_MAX FROM product_date WHERE ID = :p0';
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
            $obj = new ChildProductDate();
            $obj->hydrate($row);
            ProductDateTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param mixed               $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @return ChildProductDate|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
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
     * @param array               $keys Primary keys to use for the query
     * @param ConnectionInterface $con  an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
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
     * @return ChildProductDateQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        return $this->addUsingAlias(ProductDateTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array $keys The list of primary key to use for the query
     *
     * @return ChildProductDateQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        return $this->addUsingAlias(ProductDateTableMap::ID, $keys, Criteria::IN);
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
     * @see       filterByProductSaleElements()
     *
     * @param mixed  $id         The value to use as filter.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductDateQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProductDateTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProductDateTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductDateTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the delivery_time_min column
     *
     * Example usage:
     * <code>
     * $query->filterByDeliveryTimeMin(1234); // WHERE delivery_time_min = 1234
     * $query->filterByDeliveryTimeMin(array(12, 34)); // WHERE delivery_time_min IN (12, 34)
     * $query->filterByDeliveryTimeMin(array('min' => 12)); // WHERE delivery_time_min > 12
     * </code>
     *
     * @param mixed  $deliveryTimeMin The value to use as filter.
     *                                Use scalar values for equality.
     *                                Use array values for in_array() equivalent.
     *                                Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison      Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductDateQuery The current query, for fluid interface
     */
    public function filterByDeliveryTimeMin($deliveryTimeMin = null, $comparison = null)
    {
        if (is_array($deliveryTimeMin)) {
            $useMinMax = false;
            if (isset($deliveryTimeMin['min'])) {
                $this->addUsingAlias(ProductDateTableMap::DELIVERY_TIME_MIN, $deliveryTimeMin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deliveryTimeMin['max'])) {
                $this->addUsingAlias(ProductDateTableMap::DELIVERY_TIME_MIN, $deliveryTimeMin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductDateTableMap::DELIVERY_TIME_MIN, $deliveryTimeMin, $comparison);
    }

    /**
     * Filter the query on the delivery_time_max column
     *
     * Example usage:
     * <code>
     * $query->filterByDeliveryTimeMax(1234); // WHERE delivery_time_max = 1234
     * $query->filterByDeliveryTimeMax(array(12, 34)); // WHERE delivery_time_max IN (12, 34)
     * $query->filterByDeliveryTimeMax(array('min' => 12)); // WHERE delivery_time_max > 12
     * </code>
     *
     * @param mixed  $deliveryTimeMax The value to use as filter.
     *                                Use scalar values for equality.
     *                                Use array values for in_array() equivalent.
     *                                Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison      Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductDateQuery The current query, for fluid interface
     */
    public function filterByDeliveryTimeMax($deliveryTimeMax = null, $comparison = null)
    {
        if (is_array($deliveryTimeMax)) {
            $useMinMax = false;
            if (isset($deliveryTimeMax['min'])) {
                $this->addUsingAlias(ProductDateTableMap::DELIVERY_TIME_MAX, $deliveryTimeMax['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deliveryTimeMax['max'])) {
                $this->addUsingAlias(ProductDateTableMap::DELIVERY_TIME_MAX, $deliveryTimeMax['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductDateTableMap::DELIVERY_TIME_MAX, $deliveryTimeMax, $comparison);
    }

    /**
     * Filter the query on the restock_time_min column
     *
     * Example usage:
     * <code>
     * $query->filterByRestockTimeMin(1234); // WHERE restock_time_min = 1234
     * $query->filterByRestockTimeMin(array(12, 34)); // WHERE restock_time_min IN (12, 34)
     * $query->filterByRestockTimeMin(array('min' => 12)); // WHERE restock_time_min > 12
     * </code>
     *
     * @param mixed  $restockTimeMin The value to use as filter.
     *                               Use scalar values for equality.
     *                               Use array values for in_array() equivalent.
     *                               Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison     Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductDateQuery The current query, for fluid interface
     */
    public function filterByRestockTimeMin($restockTimeMin = null, $comparison = null)
    {
        if (is_array($restockTimeMin)) {
            $useMinMax = false;
            if (isset($restockTimeMin['min'])) {
                $this->addUsingAlias(ProductDateTableMap::RESTOCK_TIME_MIN, $restockTimeMin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($restockTimeMin['max'])) {
                $this->addUsingAlias(ProductDateTableMap::RESTOCK_TIME_MIN, $restockTimeMin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductDateTableMap::RESTOCK_TIME_MIN, $restockTimeMin, $comparison);
    }

    /**
     * Filter the query on the restock_time_max column
     *
     * Example usage:
     * <code>
     * $query->filterByRestockTimeMax(1234); // WHERE restock_time_max = 1234
     * $query->filterByRestockTimeMax(array(12, 34)); // WHERE restock_time_max IN (12, 34)
     * $query->filterByRestockTimeMax(array('min' => 12)); // WHERE restock_time_max > 12
     * </code>
     *
     * @param mixed  $restockTimeMax The value to use as filter.
     *                               Use scalar values for equality.
     *                               Use array values for in_array() equivalent.
     *                               Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison     Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductDateQuery The current query, for fluid interface
     */
    public function filterByRestockTimeMax($restockTimeMax = null, $comparison = null)
    {
        if (is_array($restockTimeMax)) {
            $useMinMax = false;
            if (isset($restockTimeMax['min'])) {
                $this->addUsingAlias(ProductDateTableMap::RESTOCK_TIME_MAX, $restockTimeMax['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($restockTimeMax['max'])) {
                $this->addUsingAlias(ProductDateTableMap::RESTOCK_TIME_MAX, $restockTimeMax['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductDateTableMap::RESTOCK_TIME_MAX, $restockTimeMax, $comparison);
    }

    /**
     * Filter the query by a related \DeliveryDate\Model\Thelia\Model\ProductSaleElements object
     *
     * @param \DeliveryDate\Model\Thelia\Model\ProductSaleElements|ObjectCollection $productSaleElements The related object(s) to use as filter
     * @param string                                                                $comparison          Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductDateQuery The current query, for fluid interface
     */
    public function filterByProductSaleElements($productSaleElements, $comparison = null)
    {
        if ($productSaleElements instanceof \DeliveryDate\Model\Thelia\Model\ProductSaleElements) {
            return $this
                ->addUsingAlias(ProductDateTableMap::ID, $productSaleElements->getId(), $comparison);
        } elseif ($productSaleElements instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProductDateTableMap::ID, $productSaleElements->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProductSaleElements() only accepts arguments of type \DeliveryDate\Model\Thelia\Model\ProductSaleElements or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductSaleElements relation
     *
     * @param string $relationAlias optional alias for the relation
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildProductDateQuery The current query, for fluid interface
     */
    public function joinProductSaleElements($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProductSaleElements');

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
            $this->addJoinObject($join, 'ProductSaleElements');
        }

        return $this;
    }

    /**
     * Use the ProductSaleElements relation ProductSaleElements object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                              to be used as main alias in the secondary query
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DeliveryDate\Model\Thelia\Model\ProductSaleElementsQuery A secondary query class using the current class as primary query
     */
    public function useProductSaleElementsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProductSaleElements($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductSaleElements', '\DeliveryDate\Model\Thelia\Model\ProductSaleElementsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param ChildProductDate $productDate Object to remove from the list of results
     *
     * @return ChildProductDateQuery The current query, for fluid interface
     */
    public function prune($productDate = null)
    {
        if ($productDate) {
            $this->addUsingAlias(ProductDateTableMap::ID, $productDate->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the product_date table.
     *
     * @param  ConnectionInterface $con the connection to use
     * @return int                 The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductDateTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProductDateTableMap::clearInstancePool();
            ProductDateTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildProductDate or Criteria object OR a primary key value.
     *
     * @param  mixed               $values Criteria or ChildProductDate object or primary key or array of primary keys
     *                                     which is used to create the DELETE statement
     * @param  ConnectionInterface $con    the connection to use
     * @return int                 The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                                    if supported by native driver or if emulated using Propel.
     * @throws PropelException     Any exceptions caught during processing will be
     *                                    rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductDateTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProductDateTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

        ProductDateTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ProductDateTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ProductDateQuery
