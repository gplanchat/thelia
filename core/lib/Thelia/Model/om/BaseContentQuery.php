<?php

namespace Thelia\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Thelia\Model\Content;
use Thelia\Model\ContentAssoc;
use Thelia\Model\ContentFolder;
use Thelia\Model\ContentI18n;
use Thelia\Model\ContentPeer;
use Thelia\Model\ContentQuery;
use Thelia\Model\ContentVersion;
use Thelia\Model\Document;
use Thelia\Model\Image;
use Thelia\Model\Rewriting;

/**
 * Base class that represents a query for the 'content' table.
 *
 *
 *
 * @method ContentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ContentQuery orderByVisible($order = Criteria::ASC) Order by the visible column
 * @method ContentQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method ContentQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method ContentQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method ContentQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method ContentQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method ContentQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 *
 * @method ContentQuery groupById() Group by the id column
 * @method ContentQuery groupByVisible() Group by the visible column
 * @method ContentQuery groupByPosition() Group by the position column
 * @method ContentQuery groupByCreatedAt() Group by the created_at column
 * @method ContentQuery groupByUpdatedAt() Group by the updated_at column
 * @method ContentQuery groupByVersion() Group by the version column
 * @method ContentQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method ContentQuery groupByVersionCreatedBy() Group by the version_created_by column
 *
 * @method ContentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ContentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ContentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ContentQuery leftJoinContentAssoc($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentAssoc relation
 * @method ContentQuery rightJoinContentAssoc($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentAssoc relation
 * @method ContentQuery innerJoinContentAssoc($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentAssoc relation
 *
 * @method ContentQuery leftJoinImage($relationAlias = null) Adds a LEFT JOIN clause to the query using the Image relation
 * @method ContentQuery rightJoinImage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Image relation
 * @method ContentQuery innerJoinImage($relationAlias = null) Adds a INNER JOIN clause to the query using the Image relation
 *
 * @method ContentQuery leftJoinDocument($relationAlias = null) Adds a LEFT JOIN clause to the query using the Document relation
 * @method ContentQuery rightJoinDocument($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Document relation
 * @method ContentQuery innerJoinDocument($relationAlias = null) Adds a INNER JOIN clause to the query using the Document relation
 *
 * @method ContentQuery leftJoinRewriting($relationAlias = null) Adds a LEFT JOIN clause to the query using the Rewriting relation
 * @method ContentQuery rightJoinRewriting($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Rewriting relation
 * @method ContentQuery innerJoinRewriting($relationAlias = null) Adds a INNER JOIN clause to the query using the Rewriting relation
 *
 * @method ContentQuery leftJoinContentFolder($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentFolder relation
 * @method ContentQuery rightJoinContentFolder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentFolder relation
 * @method ContentQuery innerJoinContentFolder($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentFolder relation
 *
 * @method ContentQuery leftJoinContentI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentI18n relation
 * @method ContentQuery rightJoinContentI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentI18n relation
 * @method ContentQuery innerJoinContentI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentI18n relation
 *
 * @method ContentQuery leftJoinContentVersion($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentVersion relation
 * @method ContentQuery rightJoinContentVersion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentVersion relation
 * @method ContentQuery innerJoinContentVersion($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentVersion relation
 *
 * @method Content findOne(PropelPDO $con = null) Return the first Content matching the query
 * @method Content findOneOrCreate(PropelPDO $con = null) Return the first Content matching the query, or a new Content object populated from the query conditions when no match is found
 *
 * @method Content findOneByVisible(int $visible) Return the first Content filtered by the visible column
 * @method Content findOneByPosition(int $position) Return the first Content filtered by the position column
 * @method Content findOneByCreatedAt(string $created_at) Return the first Content filtered by the created_at column
 * @method Content findOneByUpdatedAt(string $updated_at) Return the first Content filtered by the updated_at column
 * @method Content findOneByVersion(int $version) Return the first Content filtered by the version column
 * @method Content findOneByVersionCreatedAt(string $version_created_at) Return the first Content filtered by the version_created_at column
 * @method Content findOneByVersionCreatedBy(string $version_created_by) Return the first Content filtered by the version_created_by column
 *
 * @method array findById(int $id) Return Content objects filtered by the id column
 * @method array findByVisible(int $visible) Return Content objects filtered by the visible column
 * @method array findByPosition(int $position) Return Content objects filtered by the position column
 * @method array findByCreatedAt(string $created_at) Return Content objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return Content objects filtered by the updated_at column
 * @method array findByVersion(int $version) Return Content objects filtered by the version column
 * @method array findByVersionCreatedAt(string $version_created_at) Return Content objects filtered by the version_created_at column
 * @method array findByVersionCreatedBy(string $version_created_by) Return Content objects filtered by the version_created_by column
 *
 * @package    propel.generator.Thelia.Model.om
 */
abstract class BaseContentQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseContentQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = 'Thelia\\Model\\Content', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ContentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ContentQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ContentQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ContentQuery) {
            return $criteria;
        }
        $query = new ContentQuery();
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
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Content|Content[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ContentPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Content A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Content A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `visible`, `position`, `created_at`, `updated_at`, `version`, `version_created_at`, `version_created_by` FROM `content` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Content();
            $obj->hydrate($row);
            ContentPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Content|Content[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Content[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ContentPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ContentPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ContentPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ContentPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the visible column
     *
     * Example usage:
     * <code>
     * $query->filterByVisible(1234); // WHERE visible = 1234
     * $query->filterByVisible(array(12, 34)); // WHERE visible IN (12, 34)
     * $query->filterByVisible(array('min' => 12)); // WHERE visible >= 12
     * $query->filterByVisible(array('max' => 12)); // WHERE visible <= 12
     * </code>
     *
     * @param     mixed $visible The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function filterByVisible($visible = null, $comparison = null)
    {
        if (is_array($visible)) {
            $useMinMax = false;
            if (isset($visible['min'])) {
                $this->addUsingAlias(ContentPeer::VISIBLE, $visible['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visible['max'])) {
                $this->addUsingAlias(ContentPeer::VISIBLE, $visible['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentPeer::VISIBLE, $visible, $comparison);
    }

    /**
     * Filter the query on the position column
     *
     * Example usage:
     * <code>
     * $query->filterByPosition(1234); // WHERE position = 1234
     * $query->filterByPosition(array(12, 34)); // WHERE position IN (12, 34)
     * $query->filterByPosition(array('min' => 12)); // WHERE position >= 12
     * $query->filterByPosition(array('max' => 12)); // WHERE position <= 12
     * </code>
     *
     * @param     mixed $position The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(ContentPeer::POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(ContentPeer::POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentPeer::POSITION, $position, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ContentPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ContentPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentPeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ContentPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ContentPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query on the version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion(1234); // WHERE version = 1234
     * $query->filterByVersion(array(12, 34)); // WHERE version IN (12, 34)
     * $query->filterByVersion(array('min' => 12)); // WHERE version >= 12
     * $query->filterByVersion(array('max' => 12)); // WHERE version <= 12
     * </code>
     *
     * @param     mixed $version The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(ContentPeer::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(ContentPeer::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentPeer::VERSION, $version, $comparison);
    }

    /**
     * Filter the query on the version_created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedAt('2011-03-14'); // WHERE version_created_at = '2011-03-14'
     * $query->filterByVersionCreatedAt('now'); // WHERE version_created_at = '2011-03-14'
     * $query->filterByVersionCreatedAt(array('max' => 'yesterday')); // WHERE version_created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $versionCreatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(ContentPeer::VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(ContentPeer::VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentPeer::VERSION_CREATED_AT, $versionCreatedAt, $comparison);
    }

    /**
     * Filter the query on the version_created_by column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedBy('fooValue');   // WHERE version_created_by = 'fooValue'
     * $query->filterByVersionCreatedBy('%fooValue%'); // WHERE version_created_by LIKE '%fooValue%'
     * </code>
     *
     * @param     string $versionCreatedBy The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedBy($versionCreatedBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($versionCreatedBy)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $versionCreatedBy)) {
                $versionCreatedBy = str_replace('*', '%', $versionCreatedBy);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ContentPeer::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query by a related ContentAssoc object
     *
     * @param   ContentAssoc|PropelObjectCollection $contentAssoc  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ContentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContentAssoc($contentAssoc, $comparison = null)
    {
        if ($contentAssoc instanceof ContentAssoc) {
            return $this
                ->addUsingAlias(ContentPeer::ID, $contentAssoc->getContentId(), $comparison);
        } elseif ($contentAssoc instanceof PropelObjectCollection) {
            return $this
                ->useContentAssocQuery()
                ->filterByPrimaryKeys($contentAssoc->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContentAssoc() only accepts arguments of type ContentAssoc or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ContentAssoc relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function joinContentAssoc($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ContentAssoc');

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
            $this->addJoinObject($join, 'ContentAssoc');
        }

        return $this;
    }

    /**
     * Use the ContentAssoc relation ContentAssoc object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\ContentAssocQuery A secondary query class using the current class as primary query
     */
    public function useContentAssocQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinContentAssoc($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContentAssoc', '\Thelia\Model\ContentAssocQuery');
    }

    /**
     * Filter the query by a related Image object
     *
     * @param   Image|PropelObjectCollection $image  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ContentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByImage($image, $comparison = null)
    {
        if ($image instanceof Image) {
            return $this
                ->addUsingAlias(ContentPeer::ID, $image->getContentId(), $comparison);
        } elseif ($image instanceof PropelObjectCollection) {
            return $this
                ->useImageQuery()
                ->filterByPrimaryKeys($image->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByImage() only accepts arguments of type Image or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Image relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function joinImage($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Image');

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
            $this->addJoinObject($join, 'Image');
        }

        return $this;
    }

    /**
     * Use the Image relation Image object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\ImageQuery A secondary query class using the current class as primary query
     */
    public function useImageQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinImage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Image', '\Thelia\Model\ImageQuery');
    }

    /**
     * Filter the query by a related Document object
     *
     * @param   Document|PropelObjectCollection $document  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ContentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDocument($document, $comparison = null)
    {
        if ($document instanceof Document) {
            return $this
                ->addUsingAlias(ContentPeer::ID, $document->getContentId(), $comparison);
        } elseif ($document instanceof PropelObjectCollection) {
            return $this
                ->useDocumentQuery()
                ->filterByPrimaryKeys($document->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDocument() only accepts arguments of type Document or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Document relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function joinDocument($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Document');

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
            $this->addJoinObject($join, 'Document');
        }

        return $this;
    }

    /**
     * Use the Document relation Document object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\DocumentQuery A secondary query class using the current class as primary query
     */
    public function useDocumentQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDocument($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Document', '\Thelia\Model\DocumentQuery');
    }

    /**
     * Filter the query by a related Rewriting object
     *
     * @param   Rewriting|PropelObjectCollection $rewriting  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ContentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByRewriting($rewriting, $comparison = null)
    {
        if ($rewriting instanceof Rewriting) {
            return $this
                ->addUsingAlias(ContentPeer::ID, $rewriting->getContentId(), $comparison);
        } elseif ($rewriting instanceof PropelObjectCollection) {
            return $this
                ->useRewritingQuery()
                ->filterByPrimaryKeys($rewriting->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRewriting() only accepts arguments of type Rewriting or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Rewriting relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function joinRewriting($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Rewriting');

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
            $this->addJoinObject($join, 'Rewriting');
        }

        return $this;
    }

    /**
     * Use the Rewriting relation Rewriting object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\RewritingQuery A secondary query class using the current class as primary query
     */
    public function useRewritingQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRewriting($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Rewriting', '\Thelia\Model\RewritingQuery');
    }

    /**
     * Filter the query by a related ContentFolder object
     *
     * @param   ContentFolder|PropelObjectCollection $contentFolder  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ContentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContentFolder($contentFolder, $comparison = null)
    {
        if ($contentFolder instanceof ContentFolder) {
            return $this
                ->addUsingAlias(ContentPeer::ID, $contentFolder->getContentId(), $comparison);
        } elseif ($contentFolder instanceof PropelObjectCollection) {
            return $this
                ->useContentFolderQuery()
                ->filterByPrimaryKeys($contentFolder->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContentFolder() only accepts arguments of type ContentFolder or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ContentFolder relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function joinContentFolder($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ContentFolder');

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
            $this->addJoinObject($join, 'ContentFolder');
        }

        return $this;
    }

    /**
     * Use the ContentFolder relation ContentFolder object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\ContentFolderQuery A secondary query class using the current class as primary query
     */
    public function useContentFolderQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContentFolder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContentFolder', '\Thelia\Model\ContentFolderQuery');
    }

    /**
     * Filter the query by a related ContentI18n object
     *
     * @param   ContentI18n|PropelObjectCollection $contentI18n  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ContentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContentI18n($contentI18n, $comparison = null)
    {
        if ($contentI18n instanceof ContentI18n) {
            return $this
                ->addUsingAlias(ContentPeer::ID, $contentI18n->getId(), $comparison);
        } elseif ($contentI18n instanceof PropelObjectCollection) {
            return $this
                ->useContentI18nQuery()
                ->filterByPrimaryKeys($contentI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContentI18n() only accepts arguments of type ContentI18n or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ContentI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function joinContentI18n($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ContentI18n');

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
            $this->addJoinObject($join, 'ContentI18n');
        }

        return $this;
    }

    /**
     * Use the ContentI18n relation ContentI18n object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\ContentI18nQuery A secondary query class using the current class as primary query
     */
    public function useContentI18nQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinContentI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContentI18n', '\Thelia\Model\ContentI18nQuery');
    }

    /**
     * Filter the query by a related ContentVersion object
     *
     * @param   ContentVersion|PropelObjectCollection $contentVersion  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ContentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContentVersion($contentVersion, $comparison = null)
    {
        if ($contentVersion instanceof ContentVersion) {
            return $this
                ->addUsingAlias(ContentPeer::ID, $contentVersion->getId(), $comparison);
        } elseif ($contentVersion instanceof PropelObjectCollection) {
            return $this
                ->useContentVersionQuery()
                ->filterByPrimaryKeys($contentVersion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContentVersion() only accepts arguments of type ContentVersion or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ContentVersion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function joinContentVersion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ContentVersion');

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
            $this->addJoinObject($join, 'ContentVersion');
        }

        return $this;
    }

    /**
     * Use the ContentVersion relation ContentVersion object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\ContentVersionQuery A secondary query class using the current class as primary query
     */
    public function useContentVersionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContentVersion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContentVersion', '\Thelia\Model\ContentVersionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Content $content Object to remove from the list of results
     *
     * @return ContentQuery The current query, for fluid interface
     */
    public function prune($content = null)
    {
        if ($content) {
            $this->addUsingAlias(ContentPeer::ID, $content->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ContentQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ContentPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ContentQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ContentPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ContentQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ContentPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ContentQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ContentPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     ContentQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ContentPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ContentQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ContentPeer::CREATED_AT);
    }
    // i18n behavior

    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ContentQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'en_US', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'ContentI18n';

        return $this
            ->joinContentI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ContentQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'en_US', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('ContentI18n');
        $this->with['ContentI18n']->setIsWithOneToMany(false);

        return $this;
    }

    /**
     * Use the I18n relation query object
     *
     * @see       useQuery()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ContentI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'en_US', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContentI18n', 'Thelia\Model\ContentI18nQuery');
    }

}
