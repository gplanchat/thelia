<?php

namespace Thelia\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Thelia\Model\AddressPeer;
use Thelia\Model\Customer;
use Thelia\Model\CustomerPeer;
use Thelia\Model\CustomerTitlePeer;
use Thelia\Model\OrderPeer;
use Thelia\Model\map\CustomerTableMap;

/**
 * Base static class for performing query and update operations on the 'customer' table.
 *
 *
 *
 * @package propel.generator.Thelia.Model.om
 */
abstract class BaseCustomerPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'thelia';

    /** the table name for this class */
    const TABLE_NAME = 'customer';

    /** the related Propel class for this table */
    const OM_CLASS = 'Thelia\\Model\\Customer';

    /** the related TableMap class for this table */
    const TM_CLASS = 'CustomerTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 24;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 24;

    /** the column name for the id field */
    const ID = 'customer.id';

    /** the column name for the ref field */
    const REF = 'customer.ref';

    /** the column name for the customer_title_id field */
    const CUSTOMER_TITLE_ID = 'customer.customer_title_id';

    /** the column name for the company field */
    const COMPANY = 'customer.company';

    /** the column name for the firstname field */
    const FIRSTNAME = 'customer.firstname';

    /** the column name for the lastname field */
    const LASTNAME = 'customer.lastname';

    /** the column name for the address1 field */
    const ADDRESS1 = 'customer.address1';

    /** the column name for the address2 field */
    const ADDRESS2 = 'customer.address2';

    /** the column name for the address3 field */
    const ADDRESS3 = 'customer.address3';

    /** the column name for the zipcode field */
    const ZIPCODE = 'customer.zipcode';

    /** the column name for the city field */
    const CITY = 'customer.city';

    /** the column name for the country_id field */
    const COUNTRY_ID = 'customer.country_id';

    /** the column name for the phone field */
    const PHONE = 'customer.phone';

    /** the column name for the cellphone field */
    const CELLPHONE = 'customer.cellphone';

    /** the column name for the email field */
    const EMAIL = 'customer.email';

    /** the column name for the password field */
    const PASSWORD = 'customer.password';

    /** the column name for the algo field */
    const ALGO = 'customer.algo';

    /** the column name for the salt field */
    const SALT = 'customer.salt';

    /** the column name for the reseller field */
    const RESELLER = 'customer.reseller';

    /** the column name for the lang field */
    const LANG = 'customer.lang';

    /** the column name for the sponsor field */
    const SPONSOR = 'customer.sponsor';

    /** the column name for the discount field */
    const DISCOUNT = 'customer.discount';

    /** the column name for the created_at field */
    const CREATED_AT = 'customer.created_at';

    /** the column name for the updated_at field */
    const UPDATED_AT = 'customer.updated_at';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identiy map to hold any loaded instances of Customer objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Customer[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. CustomerPeer::$fieldNames[CustomerPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'Ref', 'CustomerTitleId', 'Company', 'Firstname', 'Lastname', 'Address1', 'Address2', 'Address3', 'Zipcode', 'City', 'CountryId', 'Phone', 'Cellphone', 'Email', 'Password', 'Algo', 'Salt', 'Reseller', 'Lang', 'Sponsor', 'Discount', 'CreatedAt', 'UpdatedAt', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'ref', 'customerTitleId', 'company', 'firstname', 'lastname', 'address1', 'address2', 'address3', 'zipcode', 'city', 'countryId', 'phone', 'cellphone', 'email', 'password', 'algo', 'salt', 'reseller', 'lang', 'sponsor', 'discount', 'createdAt', 'updatedAt', ),
        BasePeer::TYPE_COLNAME => array (CustomerPeer::ID, CustomerPeer::REF, CustomerPeer::CUSTOMER_TITLE_ID, CustomerPeer::COMPANY, CustomerPeer::FIRSTNAME, CustomerPeer::LASTNAME, CustomerPeer::ADDRESS1, CustomerPeer::ADDRESS2, CustomerPeer::ADDRESS3, CustomerPeer::ZIPCODE, CustomerPeer::CITY, CustomerPeer::COUNTRY_ID, CustomerPeer::PHONE, CustomerPeer::CELLPHONE, CustomerPeer::EMAIL, CustomerPeer::PASSWORD, CustomerPeer::ALGO, CustomerPeer::SALT, CustomerPeer::RESELLER, CustomerPeer::LANG, CustomerPeer::SPONSOR, CustomerPeer::DISCOUNT, CustomerPeer::CREATED_AT, CustomerPeer::UPDATED_AT, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'REF', 'CUSTOMER_TITLE_ID', 'COMPANY', 'FIRSTNAME', 'LASTNAME', 'ADDRESS1', 'ADDRESS2', 'ADDRESS3', 'ZIPCODE', 'CITY', 'COUNTRY_ID', 'PHONE', 'CELLPHONE', 'EMAIL', 'PASSWORD', 'ALGO', 'SALT', 'RESELLER', 'LANG', 'SPONSOR', 'DISCOUNT', 'CREATED_AT', 'UPDATED_AT', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'ref', 'customer_title_id', 'company', 'firstname', 'lastname', 'address1', 'address2', 'address3', 'zipcode', 'city', 'country_id', 'phone', 'cellphone', 'email', 'password', 'algo', 'salt', 'reseller', 'lang', 'sponsor', 'discount', 'created_at', 'updated_at', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. CustomerPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Ref' => 1, 'CustomerTitleId' => 2, 'Company' => 3, 'Firstname' => 4, 'Lastname' => 5, 'Address1' => 6, 'Address2' => 7, 'Address3' => 8, 'Zipcode' => 9, 'City' => 10, 'CountryId' => 11, 'Phone' => 12, 'Cellphone' => 13, 'Email' => 14, 'Password' => 15, 'Algo' => 16, 'Salt' => 17, 'Reseller' => 18, 'Lang' => 19, 'Sponsor' => 20, 'Discount' => 21, 'CreatedAt' => 22, 'UpdatedAt' => 23, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'ref' => 1, 'customerTitleId' => 2, 'company' => 3, 'firstname' => 4, 'lastname' => 5, 'address1' => 6, 'address2' => 7, 'address3' => 8, 'zipcode' => 9, 'city' => 10, 'countryId' => 11, 'phone' => 12, 'cellphone' => 13, 'email' => 14, 'password' => 15, 'algo' => 16, 'salt' => 17, 'reseller' => 18, 'lang' => 19, 'sponsor' => 20, 'discount' => 21, 'createdAt' => 22, 'updatedAt' => 23, ),
        BasePeer::TYPE_COLNAME => array (CustomerPeer::ID => 0, CustomerPeer::REF => 1, CustomerPeer::CUSTOMER_TITLE_ID => 2, CustomerPeer::COMPANY => 3, CustomerPeer::FIRSTNAME => 4, CustomerPeer::LASTNAME => 5, CustomerPeer::ADDRESS1 => 6, CustomerPeer::ADDRESS2 => 7, CustomerPeer::ADDRESS3 => 8, CustomerPeer::ZIPCODE => 9, CustomerPeer::CITY => 10, CustomerPeer::COUNTRY_ID => 11, CustomerPeer::PHONE => 12, CustomerPeer::CELLPHONE => 13, CustomerPeer::EMAIL => 14, CustomerPeer::PASSWORD => 15, CustomerPeer::ALGO => 16, CustomerPeer::SALT => 17, CustomerPeer::RESELLER => 18, CustomerPeer::LANG => 19, CustomerPeer::SPONSOR => 20, CustomerPeer::DISCOUNT => 21, CustomerPeer::CREATED_AT => 22, CustomerPeer::UPDATED_AT => 23, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'REF' => 1, 'CUSTOMER_TITLE_ID' => 2, 'COMPANY' => 3, 'FIRSTNAME' => 4, 'LASTNAME' => 5, 'ADDRESS1' => 6, 'ADDRESS2' => 7, 'ADDRESS3' => 8, 'ZIPCODE' => 9, 'CITY' => 10, 'COUNTRY_ID' => 11, 'PHONE' => 12, 'CELLPHONE' => 13, 'EMAIL' => 14, 'PASSWORD' => 15, 'ALGO' => 16, 'SALT' => 17, 'RESELLER' => 18, 'LANG' => 19, 'SPONSOR' => 20, 'DISCOUNT' => 21, 'CREATED_AT' => 22, 'UPDATED_AT' => 23, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'ref' => 1, 'customer_title_id' => 2, 'company' => 3, 'firstname' => 4, 'lastname' => 5, 'address1' => 6, 'address2' => 7, 'address3' => 8, 'zipcode' => 9, 'city' => 10, 'country_id' => 11, 'phone' => 12, 'cellphone' => 13, 'email' => 14, 'password' => 15, 'algo' => 16, 'salt' => 17, 'reseller' => 18, 'lang' => 19, 'sponsor' => 20, 'discount' => 21, 'created_at' => 22, 'updated_at' => 23, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, )
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
        $toNames = CustomerPeer::getFieldNames($toType);
        $key = isset(CustomerPeer::$fieldKeys[$fromType][$name]) ? CustomerPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(CustomerPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, CustomerPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return CustomerPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. CustomerPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(CustomerPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(CustomerPeer::ID);
            $criteria->addSelectColumn(CustomerPeer::REF);
            $criteria->addSelectColumn(CustomerPeer::CUSTOMER_TITLE_ID);
            $criteria->addSelectColumn(CustomerPeer::COMPANY);
            $criteria->addSelectColumn(CustomerPeer::FIRSTNAME);
            $criteria->addSelectColumn(CustomerPeer::LASTNAME);
            $criteria->addSelectColumn(CustomerPeer::ADDRESS1);
            $criteria->addSelectColumn(CustomerPeer::ADDRESS2);
            $criteria->addSelectColumn(CustomerPeer::ADDRESS3);
            $criteria->addSelectColumn(CustomerPeer::ZIPCODE);
            $criteria->addSelectColumn(CustomerPeer::CITY);
            $criteria->addSelectColumn(CustomerPeer::COUNTRY_ID);
            $criteria->addSelectColumn(CustomerPeer::PHONE);
            $criteria->addSelectColumn(CustomerPeer::CELLPHONE);
            $criteria->addSelectColumn(CustomerPeer::EMAIL);
            $criteria->addSelectColumn(CustomerPeer::PASSWORD);
            $criteria->addSelectColumn(CustomerPeer::ALGO);
            $criteria->addSelectColumn(CustomerPeer::SALT);
            $criteria->addSelectColumn(CustomerPeer::RESELLER);
            $criteria->addSelectColumn(CustomerPeer::LANG);
            $criteria->addSelectColumn(CustomerPeer::SPONSOR);
            $criteria->addSelectColumn(CustomerPeer::DISCOUNT);
            $criteria->addSelectColumn(CustomerPeer::CREATED_AT);
            $criteria->addSelectColumn(CustomerPeer::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.ref');
            $criteria->addSelectColumn($alias . '.customer_title_id');
            $criteria->addSelectColumn($alias . '.company');
            $criteria->addSelectColumn($alias . '.firstname');
            $criteria->addSelectColumn($alias . '.lastname');
            $criteria->addSelectColumn($alias . '.address1');
            $criteria->addSelectColumn($alias . '.address2');
            $criteria->addSelectColumn($alias . '.address3');
            $criteria->addSelectColumn($alias . '.zipcode');
            $criteria->addSelectColumn($alias . '.city');
            $criteria->addSelectColumn($alias . '.country_id');
            $criteria->addSelectColumn($alias . '.phone');
            $criteria->addSelectColumn($alias . '.cellphone');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.password');
            $criteria->addSelectColumn($alias . '.algo');
            $criteria->addSelectColumn($alias . '.salt');
            $criteria->addSelectColumn($alias . '.reseller');
            $criteria->addSelectColumn($alias . '.lang');
            $criteria->addSelectColumn($alias . '.sponsor');
            $criteria->addSelectColumn($alias . '.discount');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
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
        $criteria->setPrimaryTableName(CustomerPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CustomerPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(CustomerPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(CustomerPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Customer
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = CustomerPeer::doSelect($critcopy, $con);
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
        return CustomerPeer::populateObjects(CustomerPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(CustomerPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            CustomerPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(CustomerPeer::DATABASE_NAME);

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
     * @param      Customer $obj A Customer object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            CustomerPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A Customer object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Customer) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Customer object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(CustomerPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return   Customer Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(CustomerPeer::$instances[$key])) {
                return CustomerPeer::$instances[$key];
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
        foreach (CustomerPeer::$instances as $instance)
        {
          $instance->clearAllReferences(true);
        }
      }
        CustomerPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to customer
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in AddressPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AddressPeer::clearInstancePool();
        // Invalidate objects in OrderPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        OrderPeer::clearInstancePool();
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
        $cls = CustomerPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = CustomerPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = CustomerPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CustomerPeer::addInstanceToPool($obj, $key);
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
     * @return array (Customer object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = CustomerPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = CustomerPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + CustomerPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CustomerPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            CustomerPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related CustomerTitle table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinCustomerTitle(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CustomerPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CustomerPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CustomerPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CustomerPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CustomerPeer::CUSTOMER_TITLE_ID, CustomerTitlePeer::ID, $join_behavior);

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
     * Selects a collection of Customer objects pre-filled with their CustomerTitle objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Customer objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinCustomerTitle(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CustomerPeer::DATABASE_NAME);
        }

        CustomerPeer::addSelectColumns($criteria);
        $startcol = CustomerPeer::NUM_HYDRATE_COLUMNS;
        CustomerTitlePeer::addSelectColumns($criteria);

        $criteria->addJoin(CustomerPeer::CUSTOMER_TITLE_ID, CustomerTitlePeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CustomerPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CustomerPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = CustomerPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CustomerPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = CustomerTitlePeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = CustomerTitlePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = CustomerTitlePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    CustomerTitlePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Customer) to $obj2 (CustomerTitle)
                $obj2->addCustomer($obj1);

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
        $criteria->setPrimaryTableName(CustomerPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CustomerPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CustomerPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CustomerPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CustomerPeer::CUSTOMER_TITLE_ID, CustomerTitlePeer::ID, $join_behavior);

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
     * Selects a collection of Customer objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Customer objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CustomerPeer::DATABASE_NAME);
        }

        CustomerPeer::addSelectColumns($criteria);
        $startcol2 = CustomerPeer::NUM_HYDRATE_COLUMNS;

        CustomerTitlePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + CustomerTitlePeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CustomerPeer::CUSTOMER_TITLE_ID, CustomerTitlePeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CustomerPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CustomerPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CustomerPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CustomerPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined CustomerTitle rows

            $key2 = CustomerTitlePeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = CustomerTitlePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = CustomerTitlePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    CustomerTitlePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (Customer) to the collection in $obj2 (CustomerTitle)
                $obj2->addCustomer($obj1);
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
        return Propel::getDatabaseMap(CustomerPeer::DATABASE_NAME)->getTable(CustomerPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseCustomerPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseCustomerPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new CustomerTableMap());
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
        return CustomerPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Customer or Criteria object.
     *
     * @param      mixed $values Criteria or Customer object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CustomerPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Customer object
        }

        if ($criteria->containsKey(CustomerPeer::ID) && $criteria->keyContainsValue(CustomerPeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CustomerPeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(CustomerPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a Customer or Criteria object.
     *
     * @param      mixed $values Criteria or Customer object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CustomerPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(CustomerPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(CustomerPeer::ID);
            $value = $criteria->remove(CustomerPeer::ID);
            if ($value) {
                $selectCriteria->add(CustomerPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(CustomerPeer::TABLE_NAME);
            }

        } else { // $values is Customer object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(CustomerPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the customer table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CustomerPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(CustomerPeer::TABLE_NAME, $con, CustomerPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CustomerPeer::clearInstancePool();
            CustomerPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Customer or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Customer object or primary key or array of primary keys
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
            $con = Propel::getConnection(CustomerPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            CustomerPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Customer) { // it's a model object
            // invalidate the cache for this single object
            CustomerPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CustomerPeer::DATABASE_NAME);
            $criteria->add(CustomerPeer::ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                CustomerPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(CustomerPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            CustomerPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Customer object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param      Customer $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(CustomerPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(CustomerPeer::TABLE_NAME);

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

        return BasePeer::doValidate(CustomerPeer::DATABASE_NAME, CustomerPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param      int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Customer
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = CustomerPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(CustomerPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(CustomerPeer::DATABASE_NAME);
        $criteria->add(CustomerPeer::ID, $pk);

        $v = CustomerPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Customer[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CustomerPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(CustomerPeer::DATABASE_NAME);
            $criteria->add(CustomerPeer::ID, $pks, Criteria::IN);
            $objs = CustomerPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseCustomerPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseCustomerPeer::buildTableMap();

