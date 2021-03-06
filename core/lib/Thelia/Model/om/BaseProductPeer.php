<?php

namespace Thelia\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Thelia\Model\AccessoryPeer;
use Thelia\Model\ContentAssocPeer;
use Thelia\Model\DocumentPeer;
use Thelia\Model\FeatureProdPeer;
use Thelia\Model\ImagePeer;
use Thelia\Model\Product;
use Thelia\Model\ProductCategoryPeer;
use Thelia\Model\ProductI18nPeer;
use Thelia\Model\ProductPeer;
use Thelia\Model\ProductVersionPeer;
use Thelia\Model\RewritingPeer;
use Thelia\Model\StockPeer;
use Thelia\Model\TaxRulePeer;
use Thelia\Model\map\ProductTableMap;

/**
 * Base static class for performing query and update operations on the 'product' table.
 *
 *
 *
 * @package propel.generator.Thelia.Model.om
 */
abstract class BaseProductPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'thelia';

    /** the table name for this class */
    const TABLE_NAME = 'product';

    /** the related Propel class for this table */
    const OM_CLASS = 'Thelia\\Model\\Product';

    /** the related TableMap class for this table */
    const TM_CLASS = 'ProductTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 17;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 17;

    /** the column name for the id field */
    const ID = 'product.id';

    /** the column name for the tax_rule_id field */
    const TAX_RULE_ID = 'product.tax_rule_id';

    /** the column name for the ref field */
    const REF = 'product.ref';

    /** the column name for the price field */
    const PRICE = 'product.price';

    /** the column name for the price2 field */
    const PRICE2 = 'product.price2';

    /** the column name for the ecotax field */
    const ECOTAX = 'product.ecotax';

    /** the column name for the newness field */
    const NEWNESS = 'product.newness';

    /** the column name for the promo field */
    const PROMO = 'product.promo';

    /** the column name for the stock field */
    const STOCK = 'product.stock';

    /** the column name for the visible field */
    const VISIBLE = 'product.visible';

    /** the column name for the weight field */
    const WEIGHT = 'product.weight';

    /** the column name for the position field */
    const POSITION = 'product.position';

    /** the column name for the created_at field */
    const CREATED_AT = 'product.created_at';

    /** the column name for the updated_at field */
    const UPDATED_AT = 'product.updated_at';

    /** the column name for the version field */
    const VERSION = 'product.version';

    /** the column name for the version_created_at field */
    const VERSION_CREATED_AT = 'product.version_created_at';

    /** the column name for the version_created_by field */
    const VERSION_CREATED_BY = 'product.version_created_by';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identiy map to hold any loaded instances of Product objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Product[]
     */
    public static $instances = array();


    // i18n behavior

    /**
     * The default locale to use for translations
     * @var        string
     */
    const DEFAULT_LOCALE = 'en_US';
    // versionable behavior

    /**
     * Whether the versioning is enabled
     */
    static $isVersioningEnabled = true;

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. ProductPeer::$fieldNames[ProductPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'TaxRuleId', 'Ref', 'Price', 'Price2', 'Ecotax', 'Newness', 'Promo', 'Stock', 'Visible', 'Weight', 'Position', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'taxRuleId', 'ref', 'price', 'price2', 'ecotax', 'newness', 'promo', 'stock', 'visible', 'weight', 'position', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', ),
        BasePeer::TYPE_COLNAME => array (ProductPeer::ID, ProductPeer::TAX_RULE_ID, ProductPeer::REF, ProductPeer::PRICE, ProductPeer::PRICE2, ProductPeer::ECOTAX, ProductPeer::NEWNESS, ProductPeer::PROMO, ProductPeer::STOCK, ProductPeer::VISIBLE, ProductPeer::WEIGHT, ProductPeer::POSITION, ProductPeer::CREATED_AT, ProductPeer::UPDATED_AT, ProductPeer::VERSION, ProductPeer::VERSION_CREATED_AT, ProductPeer::VERSION_CREATED_BY, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'TAX_RULE_ID', 'REF', 'PRICE', 'PRICE2', 'ECOTAX', 'NEWNESS', 'PROMO', 'STOCK', 'VISIBLE', 'WEIGHT', 'POSITION', 'CREATED_AT', 'UPDATED_AT', 'VERSION', 'VERSION_CREATED_AT', 'VERSION_CREATED_BY', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'tax_rule_id', 'ref', 'price', 'price2', 'ecotax', 'newness', 'promo', 'stock', 'visible', 'weight', 'position', 'created_at', 'updated_at', 'version', 'version_created_at', 'version_created_by', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. ProductPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'TaxRuleId' => 1, 'Ref' => 2, 'Price' => 3, 'Price2' => 4, 'Ecotax' => 5, 'Newness' => 6, 'Promo' => 7, 'Stock' => 8, 'Visible' => 9, 'Weight' => 10, 'Position' => 11, 'CreatedAt' => 12, 'UpdatedAt' => 13, 'Version' => 14, 'VersionCreatedAt' => 15, 'VersionCreatedBy' => 16, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'taxRuleId' => 1, 'ref' => 2, 'price' => 3, 'price2' => 4, 'ecotax' => 5, 'newness' => 6, 'promo' => 7, 'stock' => 8, 'visible' => 9, 'weight' => 10, 'position' => 11, 'createdAt' => 12, 'updatedAt' => 13, 'version' => 14, 'versionCreatedAt' => 15, 'versionCreatedBy' => 16, ),
        BasePeer::TYPE_COLNAME => array (ProductPeer::ID => 0, ProductPeer::TAX_RULE_ID => 1, ProductPeer::REF => 2, ProductPeer::PRICE => 3, ProductPeer::PRICE2 => 4, ProductPeer::ECOTAX => 5, ProductPeer::NEWNESS => 6, ProductPeer::PROMO => 7, ProductPeer::STOCK => 8, ProductPeer::VISIBLE => 9, ProductPeer::WEIGHT => 10, ProductPeer::POSITION => 11, ProductPeer::CREATED_AT => 12, ProductPeer::UPDATED_AT => 13, ProductPeer::VERSION => 14, ProductPeer::VERSION_CREATED_AT => 15, ProductPeer::VERSION_CREATED_BY => 16, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'TAX_RULE_ID' => 1, 'REF' => 2, 'PRICE' => 3, 'PRICE2' => 4, 'ECOTAX' => 5, 'NEWNESS' => 6, 'PROMO' => 7, 'STOCK' => 8, 'VISIBLE' => 9, 'WEIGHT' => 10, 'POSITION' => 11, 'CREATED_AT' => 12, 'UPDATED_AT' => 13, 'VERSION' => 14, 'VERSION_CREATED_AT' => 15, 'VERSION_CREATED_BY' => 16, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'tax_rule_id' => 1, 'ref' => 2, 'price' => 3, 'price2' => 4, 'ecotax' => 5, 'newness' => 6, 'promo' => 7, 'stock' => 8, 'visible' => 9, 'weight' => 10, 'position' => 11, 'created_at' => 12, 'updated_at' => 13, 'version' => 14, 'version_created_at' => 15, 'version_created_by' => 16, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = ProductPeer::getFieldNames($toType);
        $key = isset(ProductPeer::$fieldKeys[$fromType][$name]) ? ProductPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(ProductPeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, ProductPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return ProductPeer::$fieldNames[$type];
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
     *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param      string $alias The alias for the current table.
     * @param      string $column The column name for current table. (i.e. ProductPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(ProductPeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param      Criteria $criteria object containing the columns to add.
     * @param      string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(ProductPeer::ID);
            $criteria->addSelectColumn(ProductPeer::TAX_RULE_ID);
            $criteria->addSelectColumn(ProductPeer::REF);
            $criteria->addSelectColumn(ProductPeer::PRICE);
            $criteria->addSelectColumn(ProductPeer::PRICE2);
            $criteria->addSelectColumn(ProductPeer::ECOTAX);
            $criteria->addSelectColumn(ProductPeer::NEWNESS);
            $criteria->addSelectColumn(ProductPeer::PROMO);
            $criteria->addSelectColumn(ProductPeer::STOCK);
            $criteria->addSelectColumn(ProductPeer::VISIBLE);
            $criteria->addSelectColumn(ProductPeer::WEIGHT);
            $criteria->addSelectColumn(ProductPeer::POSITION);
            $criteria->addSelectColumn(ProductPeer::CREATED_AT);
            $criteria->addSelectColumn(ProductPeer::UPDATED_AT);
            $criteria->addSelectColumn(ProductPeer::VERSION);
            $criteria->addSelectColumn(ProductPeer::VERSION_CREATED_AT);
            $criteria->addSelectColumn(ProductPeer::VERSION_CREATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.tax_rule_id');
            $criteria->addSelectColumn($alias . '.ref');
            $criteria->addSelectColumn($alias . '.price');
            $criteria->addSelectColumn($alias . '.price2');
            $criteria->addSelectColumn($alias . '.ecotax');
            $criteria->addSelectColumn($alias . '.newness');
            $criteria->addSelectColumn($alias . '.promo');
            $criteria->addSelectColumn($alias . '.stock');
            $criteria->addSelectColumn($alias . '.visible');
            $criteria->addSelectColumn($alias . '.weight');
            $criteria->addSelectColumn($alias . '.position');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
            $criteria->addSelectColumn($alias . '.version');
            $criteria->addSelectColumn($alias . '.version_created_at');
            $criteria->addSelectColumn($alias . '.version_created_by');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ProductPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ProductPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(ProductPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param      Criteria $criteria object used to create the SELECT statement.
     * @param      PropelPDO $con
     * @return                 Product
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = ProductPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }
    /**
     * Selects several row from the DB.
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con
     * @return array           Array of selected Objects
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return ProductPeer::populateObjects(ProductPeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement directly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            ProductPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(ProductPeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param      Product $obj A Product object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            ProductPeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param      mixed $value A Product object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Product) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Product object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(ProductPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return   Product Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(ProductPeer::$instances[$key])) {
                return ProductPeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool($and_clear_all_references = false)
    {
      if ($and_clear_all_references)
      {
        foreach (ProductPeer::$instances as $instance)
        {
          $instance->clearAllReferences(true);
        }
      }
        ProductPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to product
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ProductCategoryPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ProductCategoryPeer::clearInstancePool();
        // Invalidate objects in FeatureProdPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        FeatureProdPeer::clearInstancePool();
        // Invalidate objects in StockPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        StockPeer::clearInstancePool();
        // Invalidate objects in ContentAssocPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ContentAssocPeer::clearInstancePool();
        // Invalidate objects in ImagePeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ImagePeer::clearInstancePool();
        // Invalidate objects in DocumentPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        DocumentPeer::clearInstancePool();
        // Invalidate objects in AccessoryPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AccessoryPeer::clearInstancePool();
        // Invalidate objects in AccessoryPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AccessoryPeer::clearInstancePool();
        // Invalidate objects in RewritingPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        RewritingPeer::clearInstancePool();
        // Invalidate objects in ProductI18nPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ProductI18nPeer::clearInstancePool();
        // Invalidate objects in ProductVersionPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ProductVersionPeer::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol] === null) {
            return null;
        }

        return (string) $row[$startcol];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return (int) $row[$startcol];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = ProductPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = ProductPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = ProductPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ProductPeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return array (Product object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = ProductPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = ProductPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + ProductPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ProductPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            ProductPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related TaxRule table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinTaxRule(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ProductPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ProductPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ProductPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ProductPeer::TAX_RULE_ID, TaxRulePeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of Product objects pre-filled with their TaxRule objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Product objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinTaxRule(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ProductPeer::DATABASE_NAME);
        }

        ProductPeer::addSelectColumns($criteria);
        $startcol = ProductPeer::NUM_HYDRATE_COLUMNS;
        TaxRulePeer::addSelectColumns($criteria);

        $criteria->addJoin(ProductPeer::TAX_RULE_ID, TaxRulePeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ProductPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ProductPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = ProductPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ProductPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = TaxRulePeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = TaxRulePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = TaxRulePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    TaxRulePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Product) to $obj2 (TaxRule)
                $obj2->addProduct($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining all related tables
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ProductPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ProductPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ProductPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ProductPeer::TAX_RULE_ID, TaxRulePeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    /**
     * Selects a collection of Product objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Product objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ProductPeer::DATABASE_NAME);
        }

        ProductPeer::addSelectColumns($criteria);
        $startcol2 = ProductPeer::NUM_HYDRATE_COLUMNS;

        TaxRulePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + TaxRulePeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ProductPeer::TAX_RULE_ID, TaxRulePeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ProductPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ProductPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ProductPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ProductPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined TaxRule rows

            $key2 = TaxRulePeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = TaxRulePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = TaxRulePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    TaxRulePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (Product) to the collection in $obj2 (TaxRule)
                $obj2->addProduct($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(ProductPeer::DATABASE_NAME)->getTable(ProductPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseProductPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseProductPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new ProductTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass($row = 0, $colnum = 0)
    {
        return ProductPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Product or Criteria object.
     *
     * @param      mixed $values Criteria or Product object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Product object
        }

        if ($criteria->containsKey(ProductPeer::ID) && $criteria->keyContainsValue(ProductPeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ProductPeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(ProductPeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a Product or Criteria object.
     *
     * @param      mixed $values Criteria or Product object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(ProductPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(ProductPeer::ID);
            $value = $criteria->remove(ProductPeer::ID);
            if ($value) {
                $selectCriteria->add(ProductPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(ProductPeer::TABLE_NAME);
            }

        } else { // $values is Product object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(ProductPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the product table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(ProductPeer::TABLE_NAME, $con, ProductPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProductPeer::clearInstancePool();
            ProductPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Product or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Product object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param      PropelPDO $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *				if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            ProductPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Product) { // it's a model object
            // invalidate the cache for this single object
            ProductPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ProductPeer::DATABASE_NAME);
            $criteria->add(ProductPeer::ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                ProductPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(ProductPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            ProductPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Product object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param      Product $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(ProductPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(ProductPeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        }

        return BasePeer::doValidate(ProductPeer::DATABASE_NAME, ProductPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param      int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Product
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = ProductPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(ProductPeer::DATABASE_NAME);
        $criteria->add(ProductPeer::ID, $pk);

        $v = ProductPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Product[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(ProductPeer::DATABASE_NAME);
            $criteria->add(ProductPeer::ID, $pks, Criteria::IN);
            $objs = ProductPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

    // versionable behavior

    /**
     * Checks whether versioning is enabled
     *
     * @return boolean
     */
    public static function isVersioningEnabled()
    {
        return self::$isVersioningEnabled;
    }

    /**
     * Enables versioning
     */
    public static function enableVersioning()
    {
        self::$isVersioningEnabled = true;
    }

    /**
     * Disables versioning
     */
    public static function disableVersioning()
    {
        self::$isVersioningEnabled = false;
    }

} // BaseProductPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseProductPeer::buildTableMap();

