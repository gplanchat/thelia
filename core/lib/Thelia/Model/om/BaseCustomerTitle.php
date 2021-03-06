<?php

namespace Thelia\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Thelia\Model\Address;
use Thelia\Model\AddressQuery;
use Thelia\Model\Customer;
use Thelia\Model\CustomerQuery;
use Thelia\Model\CustomerTitle;
use Thelia\Model\CustomerTitleI18n;
use Thelia\Model\CustomerTitleI18nQuery;
use Thelia\Model\CustomerTitlePeer;
use Thelia\Model\CustomerTitleQuery;

/**
 * Base class that represents a row from the 'customer_title' table.
 *
 *
 *
 * @package    propel.generator.Thelia.Model.om
 */
abstract class BaseCustomerTitle extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Thelia\\Model\\CustomerTitlePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        CustomerTitlePeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the by_default field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $by_default;

    /**
     * The value for the position field.
     * @var        string
     */
    protected $position;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        string
     */
    protected $updated_at;

    /**
     * @var        PropelObjectCollection|Customer[] Collection to store aggregation of Customer objects.
     */
    protected $collCustomers;
    protected $collCustomersPartial;

    /**
     * @var        PropelObjectCollection|Address[] Collection to store aggregation of Address objects.
     */
    protected $collAddresss;
    protected $collAddresssPartial;

    /**
     * @var        PropelObjectCollection|CustomerTitleI18n[] Collection to store aggregation of CustomerTitleI18n objects.
     */
    protected $collCustomerTitleI18ns;
    protected $collCustomerTitleI18nsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    // i18n behavior

    /**
     * Current locale
     * @var        string
     */
    protected $currentLocale = 'en_US';

    /**
     * Current translation objects
     * @var        array[CustomerTitleI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $customersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $addresssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $customerTitleI18nsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->by_default = 0;
    }

    /**
     * Initializes internal state of BaseCustomerTitle object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
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
     * Get the [by_default] column value.
     *
     * @return int
     */
    public function getByDefault()
    {
        return $this->by_default;
    }

    /**
     * Get the [position] column value.
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = 'Y-m-d H:i:s')
    {
        if ($this->created_at === null) {
            return null;
        }

        if ($this->created_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->created_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = 'Y-m-d H:i:s')
    {
        if ($this->updated_at === null) {
            return null;
        }

        if ($this->updated_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->updated_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return CustomerTitle The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = CustomerTitlePeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [by_default] column.
     *
     * @param int $v new value
     * @return CustomerTitle The current object (for fluent API support)
     */
    public function setByDefault($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->by_default !== $v) {
            $this->by_default = $v;
            $this->modifiedColumns[] = CustomerTitlePeer::BY_DEFAULT;
        }


        return $this;
    } // setByDefault()

    /**
     * Set the value of [position] column.
     *
     * @param string $v new value
     * @return CustomerTitle The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[] = CustomerTitlePeer::POSITION;
        }


        return $this;
    } // setPosition()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return CustomerTitle The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = CustomerTitlePeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return CustomerTitle The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            $currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->updated_at = $newDateAsString;
                $this->modifiedColumns[] = CustomerTitlePeer::UPDATED_AT;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->by_default !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->by_default = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->position = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->created_at = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->updated_at = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 5; // 5 = CustomerTitlePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating CustomerTitle object", $e);
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
     * @throws PropelException
     */
    public function ensureConsistency()
    {

    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CustomerTitlePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = CustomerTitlePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collCustomers = null;

            $this->collAddresss = null;

            $this->collCustomerTitleI18ns = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CustomerTitlePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = CustomerTitleQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CustomerTitlePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(CustomerTitlePeer::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(CustomerTitlePeer::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(CustomerTitlePeer::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                CustomerTitlePeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->customersScheduledForDeletion !== null) {
                if (!$this->customersScheduledForDeletion->isEmpty()) {
                    foreach ($this->customersScheduledForDeletion as $customer) {
                        // need to save related object because we set the relation to null
                        $customer->save($con);
                    }
                    $this->customersScheduledForDeletion = null;
                }
            }

            if ($this->collCustomers !== null) {
                foreach ($this->collCustomers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->addresssScheduledForDeletion !== null) {
                if (!$this->addresssScheduledForDeletion->isEmpty()) {
                    foreach ($this->addresssScheduledForDeletion as $address) {
                        // need to save related object because we set the relation to null
                        $address->save($con);
                    }
                    $this->addresssScheduledForDeletion = null;
                }
            }

            if ($this->collAddresss !== null) {
                foreach ($this->collAddresss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->customerTitleI18nsScheduledForDeletion !== null) {
                if (!$this->customerTitleI18nsScheduledForDeletion->isEmpty()) {
                    CustomerTitleI18nQuery::create()
                        ->filterByPrimaryKeys($this->customerTitleI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->customerTitleI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collCustomerTitleI18ns !== null) {
                foreach ($this->collCustomerTitleI18ns as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = CustomerTitlePeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CustomerTitlePeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CustomerTitlePeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(CustomerTitlePeer::BY_DEFAULT)) {
            $modifiedColumns[':p' . $index++]  = '`by_default`';
        }
        if ($this->isColumnModified(CustomerTitlePeer::POSITION)) {
            $modifiedColumns[':p' . $index++]  = '`position`';
        }
        if ($this->isColumnModified(CustomerTitlePeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(CustomerTitlePeer::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `customer_title` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`by_default`':
                        $stmt->bindValue($identifier, $this->by_default, PDO::PARAM_INT);
                        break;
                    case '`position`':
                        $stmt->bindValue($identifier, $this->position, PDO::PARAM_STR);
                        break;
                    case '`created_at`':
                        $stmt->bindValue($identifier, $this->created_at, PDO::PARAM_STR);
                        break;
                    case '`updated_at`':
                        $stmt->bindValue($identifier, $this->updated_at, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            if (($retval = CustomerTitlePeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collCustomers !== null) {
                    foreach ($this->collCustomers as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAddresss !== null) {
                    foreach ($this->collAddresss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCustomerTitleI18ns !== null) {
                    foreach ($this->collCustomerTitleI18ns as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = CustomerTitlePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getByDefault();
                break;
            case 2:
                return $this->getPosition();
                break;
            case 3:
                return $this->getCreatedAt();
                break;
            case 4:
                return $this->getUpdatedAt();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['CustomerTitle'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['CustomerTitle'][$this->getPrimaryKey()] = true;
        $keys = CustomerTitlePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getByDefault(),
            $keys[2] => $this->getPosition(),
            $keys[3] => $this->getCreatedAt(),
            $keys[4] => $this->getUpdatedAt(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->collCustomers) {
                $result['Customers'] = $this->collCustomers->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAddresss) {
                $result['Addresss'] = $this->collAddresss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCustomerTitleI18ns) {
                $result['CustomerTitleI18ns'] = $this->collCustomerTitleI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = CustomerTitlePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setByDefault($value);
                break;
            case 2:
                $this->setPosition($value);
                break;
            case 3:
                $this->setCreatedAt($value);
                break;
            case 4:
                $this->setUpdatedAt($value);
                break;
        } // switch()
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
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = CustomerTitlePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setByDefault($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setPosition($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setCreatedAt($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setUpdatedAt($arr[$keys[4]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CustomerTitlePeer::DATABASE_NAME);

        if ($this->isColumnModified(CustomerTitlePeer::ID)) $criteria->add(CustomerTitlePeer::ID, $this->id);
        if ($this->isColumnModified(CustomerTitlePeer::BY_DEFAULT)) $criteria->add(CustomerTitlePeer::BY_DEFAULT, $this->by_default);
        if ($this->isColumnModified(CustomerTitlePeer::POSITION)) $criteria->add(CustomerTitlePeer::POSITION, $this->position);
        if ($this->isColumnModified(CustomerTitlePeer::CREATED_AT)) $criteria->add(CustomerTitlePeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(CustomerTitlePeer::UPDATED_AT)) $criteria->add(CustomerTitlePeer::UPDATED_AT, $this->updated_at);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(CustomerTitlePeer::DATABASE_NAME);
        $criteria->add(CustomerTitlePeer::ID, $this->id);

        return $criteria;
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
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of CustomerTitle (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setByDefault($this->getByDefault());
        $copyObj->setPosition($this->getPosition());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getCustomers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCustomer($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAddresss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAddress($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCustomerTitleI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCustomerTitleI18n($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
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
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return CustomerTitle Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return CustomerTitlePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new CustomerTitlePeer();
        }

        return self::$peer;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Customer' == $relationName) {
            $this->initCustomers();
        }
        if ('Address' == $relationName) {
            $this->initAddresss();
        }
        if ('CustomerTitleI18n' == $relationName) {
            $this->initCustomerTitleI18ns();
        }
    }

    /**
     * Clears out the collCustomers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return CustomerTitle The current object (for fluent API support)
     * @see        addCustomers()
     */
    public function clearCustomers()
    {
        $this->collCustomers = null; // important to set this to null since that means it is uninitialized
        $this->collCustomersPartial = null;

        return $this;
    }

    /**
     * reset is the collCustomers collection loaded partially
     *
     * @return void
     */
    public function resetPartialCustomers($v = true)
    {
        $this->collCustomersPartial = $v;
    }

    /**
     * Initializes the collCustomers collection.
     *
     * By default this just sets the collCustomers collection to an empty array (like clearcollCustomers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCustomers($overrideExisting = true)
    {
        if (null !== $this->collCustomers && !$overrideExisting) {
            return;
        }
        $this->collCustomers = new PropelObjectCollection();
        $this->collCustomers->setModel('Customer');
    }

    /**
     * Gets an array of Customer objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this CustomerTitle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Customer[] List of Customer objects
     * @throws PropelException
     */
    public function getCustomers($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCustomersPartial && !$this->isNew();
        if (null === $this->collCustomers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCustomers) {
                // return empty collection
                $this->initCustomers();
            } else {
                $collCustomers = CustomerQuery::create(null, $criteria)
                    ->filterByCustomerTitle($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCustomersPartial && count($collCustomers)) {
                      $this->initCustomers(false);

                      foreach($collCustomers as $obj) {
                        if (false == $this->collCustomers->contains($obj)) {
                          $this->collCustomers->append($obj);
                        }
                      }

                      $this->collCustomersPartial = true;
                    }

                    $collCustomers->getInternalIterator()->rewind();
                    return $collCustomers;
                }

                if($partial && $this->collCustomers) {
                    foreach($this->collCustomers as $obj) {
                        if($obj->isNew()) {
                            $collCustomers[] = $obj;
                        }
                    }
                }

                $this->collCustomers = $collCustomers;
                $this->collCustomersPartial = false;
            }
        }

        return $this->collCustomers;
    }

    /**
     * Sets a collection of Customer objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $customers A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return CustomerTitle The current object (for fluent API support)
     */
    public function setCustomers(PropelCollection $customers, PropelPDO $con = null)
    {
        $customersToDelete = $this->getCustomers(new Criteria(), $con)->diff($customers);

        $this->customersScheduledForDeletion = unserialize(serialize($customersToDelete));

        foreach ($customersToDelete as $customerRemoved) {
            $customerRemoved->setCustomerTitle(null);
        }

        $this->collCustomers = null;
        foreach ($customers as $customer) {
            $this->addCustomer($customer);
        }

        $this->collCustomers = $customers;
        $this->collCustomersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Customer objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Customer objects.
     * @throws PropelException
     */
    public function countCustomers(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCustomersPartial && !$this->isNew();
        if (null === $this->collCustomers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCustomers) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCustomers());
            }
            $query = CustomerQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCustomerTitle($this)
                ->count($con);
        }

        return count($this->collCustomers);
    }

    /**
     * Method called to associate a Customer object to this object
     * through the Customer foreign key attribute.
     *
     * @param    Customer $l Customer
     * @return CustomerTitle The current object (for fluent API support)
     */
    public function addCustomer(Customer $l)
    {
        if ($this->collCustomers === null) {
            $this->initCustomers();
            $this->collCustomersPartial = true;
        }
        if (!in_array($l, $this->collCustomers->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCustomer($l);
        }

        return $this;
    }

    /**
     * @param	Customer $customer The customer object to add.
     */
    protected function doAddCustomer($customer)
    {
        $this->collCustomers[]= $customer;
        $customer->setCustomerTitle($this);
    }

    /**
     * @param	Customer $customer The customer object to remove.
     * @return CustomerTitle The current object (for fluent API support)
     */
    public function removeCustomer($customer)
    {
        if ($this->getCustomers()->contains($customer)) {
            $this->collCustomers->remove($this->collCustomers->search($customer));
            if (null === $this->customersScheduledForDeletion) {
                $this->customersScheduledForDeletion = clone $this->collCustomers;
                $this->customersScheduledForDeletion->clear();
            }
            $this->customersScheduledForDeletion[]= $customer;
            $customer->setCustomerTitle(null);
        }

        return $this;
    }

    /**
     * Clears out the collAddresss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return CustomerTitle The current object (for fluent API support)
     * @see        addAddresss()
     */
    public function clearAddresss()
    {
        $this->collAddresss = null; // important to set this to null since that means it is uninitialized
        $this->collAddresssPartial = null;

        return $this;
    }

    /**
     * reset is the collAddresss collection loaded partially
     *
     * @return void
     */
    public function resetPartialAddresss($v = true)
    {
        $this->collAddresssPartial = $v;
    }

    /**
     * Initializes the collAddresss collection.
     *
     * By default this just sets the collAddresss collection to an empty array (like clearcollAddresss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAddresss($overrideExisting = true)
    {
        if (null !== $this->collAddresss && !$overrideExisting) {
            return;
        }
        $this->collAddresss = new PropelObjectCollection();
        $this->collAddresss->setModel('Address');
    }

    /**
     * Gets an array of Address objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this CustomerTitle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Address[] List of Address objects
     * @throws PropelException
     */
    public function getAddresss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAddresssPartial && !$this->isNew();
        if (null === $this->collAddresss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAddresss) {
                // return empty collection
                $this->initAddresss();
            } else {
                $collAddresss = AddressQuery::create(null, $criteria)
                    ->filterByCustomerTitle($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAddresssPartial && count($collAddresss)) {
                      $this->initAddresss(false);

                      foreach($collAddresss as $obj) {
                        if (false == $this->collAddresss->contains($obj)) {
                          $this->collAddresss->append($obj);
                        }
                      }

                      $this->collAddresssPartial = true;
                    }

                    $collAddresss->getInternalIterator()->rewind();
                    return $collAddresss;
                }

                if($partial && $this->collAddresss) {
                    foreach($this->collAddresss as $obj) {
                        if($obj->isNew()) {
                            $collAddresss[] = $obj;
                        }
                    }
                }

                $this->collAddresss = $collAddresss;
                $this->collAddresssPartial = false;
            }
        }

        return $this->collAddresss;
    }

    /**
     * Sets a collection of Address objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $addresss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return CustomerTitle The current object (for fluent API support)
     */
    public function setAddresss(PropelCollection $addresss, PropelPDO $con = null)
    {
        $addresssToDelete = $this->getAddresss(new Criteria(), $con)->diff($addresss);

        $this->addresssScheduledForDeletion = unserialize(serialize($addresssToDelete));

        foreach ($addresssToDelete as $addressRemoved) {
            $addressRemoved->setCustomerTitle(null);
        }

        $this->collAddresss = null;
        foreach ($addresss as $address) {
            $this->addAddress($address);
        }

        $this->collAddresss = $addresss;
        $this->collAddresssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Address objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Address objects.
     * @throws PropelException
     */
    public function countAddresss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAddresssPartial && !$this->isNew();
        if (null === $this->collAddresss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAddresss) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getAddresss());
            }
            $query = AddressQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCustomerTitle($this)
                ->count($con);
        }

        return count($this->collAddresss);
    }

    /**
     * Method called to associate a Address object to this object
     * through the Address foreign key attribute.
     *
     * @param    Address $l Address
     * @return CustomerTitle The current object (for fluent API support)
     */
    public function addAddress(Address $l)
    {
        if ($this->collAddresss === null) {
            $this->initAddresss();
            $this->collAddresssPartial = true;
        }
        if (!in_array($l, $this->collAddresss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAddress($l);
        }

        return $this;
    }

    /**
     * @param	Address $address The address object to add.
     */
    protected function doAddAddress($address)
    {
        $this->collAddresss[]= $address;
        $address->setCustomerTitle($this);
    }

    /**
     * @param	Address $address The address object to remove.
     * @return CustomerTitle The current object (for fluent API support)
     */
    public function removeAddress($address)
    {
        if ($this->getAddresss()->contains($address)) {
            $this->collAddresss->remove($this->collAddresss->search($address));
            if (null === $this->addresssScheduledForDeletion) {
                $this->addresssScheduledForDeletion = clone $this->collAddresss;
                $this->addresssScheduledForDeletion->clear();
            }
            $this->addresssScheduledForDeletion[]= $address;
            $address->setCustomerTitle(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this CustomerTitle is new, it will return
     * an empty collection; or if this CustomerTitle has previously
     * been saved, it will retrieve related Addresss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in CustomerTitle.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Address[] List of Address objects
     */
    public function getAddresssJoinCustomer($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AddressQuery::create(null, $criteria);
        $query->joinWith('Customer', $join_behavior);

        return $this->getAddresss($query, $con);
    }

    /**
     * Clears out the collCustomerTitleI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return CustomerTitle The current object (for fluent API support)
     * @see        addCustomerTitleI18ns()
     */
    public function clearCustomerTitleI18ns()
    {
        $this->collCustomerTitleI18ns = null; // important to set this to null since that means it is uninitialized
        $this->collCustomerTitleI18nsPartial = null;

        return $this;
    }

    /**
     * reset is the collCustomerTitleI18ns collection loaded partially
     *
     * @return void
     */
    public function resetPartialCustomerTitleI18ns($v = true)
    {
        $this->collCustomerTitleI18nsPartial = $v;
    }

    /**
     * Initializes the collCustomerTitleI18ns collection.
     *
     * By default this just sets the collCustomerTitleI18ns collection to an empty array (like clearcollCustomerTitleI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCustomerTitleI18ns($overrideExisting = true)
    {
        if (null !== $this->collCustomerTitleI18ns && !$overrideExisting) {
            return;
        }
        $this->collCustomerTitleI18ns = new PropelObjectCollection();
        $this->collCustomerTitleI18ns->setModel('CustomerTitleI18n');
    }

    /**
     * Gets an array of CustomerTitleI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this CustomerTitle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|CustomerTitleI18n[] List of CustomerTitleI18n objects
     * @throws PropelException
     */
    public function getCustomerTitleI18ns($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCustomerTitleI18nsPartial && !$this->isNew();
        if (null === $this->collCustomerTitleI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCustomerTitleI18ns) {
                // return empty collection
                $this->initCustomerTitleI18ns();
            } else {
                $collCustomerTitleI18ns = CustomerTitleI18nQuery::create(null, $criteria)
                    ->filterByCustomerTitle($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCustomerTitleI18nsPartial && count($collCustomerTitleI18ns)) {
                      $this->initCustomerTitleI18ns(false);

                      foreach($collCustomerTitleI18ns as $obj) {
                        if (false == $this->collCustomerTitleI18ns->contains($obj)) {
                          $this->collCustomerTitleI18ns->append($obj);
                        }
                      }

                      $this->collCustomerTitleI18nsPartial = true;
                    }

                    $collCustomerTitleI18ns->getInternalIterator()->rewind();
                    return $collCustomerTitleI18ns;
                }

                if($partial && $this->collCustomerTitleI18ns) {
                    foreach($this->collCustomerTitleI18ns as $obj) {
                        if($obj->isNew()) {
                            $collCustomerTitleI18ns[] = $obj;
                        }
                    }
                }

                $this->collCustomerTitleI18ns = $collCustomerTitleI18ns;
                $this->collCustomerTitleI18nsPartial = false;
            }
        }

        return $this->collCustomerTitleI18ns;
    }

    /**
     * Sets a collection of CustomerTitleI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $customerTitleI18ns A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return CustomerTitle The current object (for fluent API support)
     */
    public function setCustomerTitleI18ns(PropelCollection $customerTitleI18ns, PropelPDO $con = null)
    {
        $customerTitleI18nsToDelete = $this->getCustomerTitleI18ns(new Criteria(), $con)->diff($customerTitleI18ns);

        $this->customerTitleI18nsScheduledForDeletion = unserialize(serialize($customerTitleI18nsToDelete));

        foreach ($customerTitleI18nsToDelete as $customerTitleI18nRemoved) {
            $customerTitleI18nRemoved->setCustomerTitle(null);
        }

        $this->collCustomerTitleI18ns = null;
        foreach ($customerTitleI18ns as $customerTitleI18n) {
            $this->addCustomerTitleI18n($customerTitleI18n);
        }

        $this->collCustomerTitleI18ns = $customerTitleI18ns;
        $this->collCustomerTitleI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CustomerTitleI18n objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related CustomerTitleI18n objects.
     * @throws PropelException
     */
    public function countCustomerTitleI18ns(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCustomerTitleI18nsPartial && !$this->isNew();
        if (null === $this->collCustomerTitleI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCustomerTitleI18ns) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCustomerTitleI18ns());
            }
            $query = CustomerTitleI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCustomerTitle($this)
                ->count($con);
        }

        return count($this->collCustomerTitleI18ns);
    }

    /**
     * Method called to associate a CustomerTitleI18n object to this object
     * through the CustomerTitleI18n foreign key attribute.
     *
     * @param    CustomerTitleI18n $l CustomerTitleI18n
     * @return CustomerTitle The current object (for fluent API support)
     */
    public function addCustomerTitleI18n(CustomerTitleI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collCustomerTitleI18ns === null) {
            $this->initCustomerTitleI18ns();
            $this->collCustomerTitleI18nsPartial = true;
        }
        if (!in_array($l, $this->collCustomerTitleI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCustomerTitleI18n($l);
        }

        return $this;
    }

    /**
     * @param	CustomerTitleI18n $customerTitleI18n The customerTitleI18n object to add.
     */
    protected function doAddCustomerTitleI18n($customerTitleI18n)
    {
        $this->collCustomerTitleI18ns[]= $customerTitleI18n;
        $customerTitleI18n->setCustomerTitle($this);
    }

    /**
     * @param	CustomerTitleI18n $customerTitleI18n The customerTitleI18n object to remove.
     * @return CustomerTitle The current object (for fluent API support)
     */
    public function removeCustomerTitleI18n($customerTitleI18n)
    {
        if ($this->getCustomerTitleI18ns()->contains($customerTitleI18n)) {
            $this->collCustomerTitleI18ns->remove($this->collCustomerTitleI18ns->search($customerTitleI18n));
            if (null === $this->customerTitleI18nsScheduledForDeletion) {
                $this->customerTitleI18nsScheduledForDeletion = clone $this->collCustomerTitleI18ns;
                $this->customerTitleI18nsScheduledForDeletion->clear();
            }
            $this->customerTitleI18nsScheduledForDeletion[]= clone $customerTitleI18n;
            $customerTitleI18n->setCustomerTitle(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->by_default = null;
        $this->position = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collCustomers) {
                foreach ($this->collCustomers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAddresss) {
                foreach ($this->collAddresss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCustomerTitleI18ns) {
                foreach ($this->collCustomerTitleI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'en_US';
        $this->currentTranslations = null;

        if ($this->collCustomers instanceof PropelCollection) {
            $this->collCustomers->clearIterator();
        }
        $this->collCustomers = null;
        if ($this->collAddresss instanceof PropelCollection) {
            $this->collAddresss->clearIterator();
        }
        $this->collAddresss = null;
        if ($this->collCustomerTitleI18ns instanceof PropelCollection) {
            $this->collCustomerTitleI18ns->clearIterator();
        }
        $this->collCustomerTitleI18ns = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CustomerTitlePeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     CustomerTitle The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[] = CustomerTitlePeer::UPDATED_AT;

        return $this;
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    CustomerTitle The current object (for fluent API support)
     */
    public function setLocale($locale = 'en_US')
    {
        $this->currentLocale = $locale;

        return $this;
    }

    /**
     * Gets the locale for translations
     *
     * @return    string $locale Locale to use for the translation, e.g. 'fr_FR'
     */
    public function getLocale()
    {
        return $this->currentLocale;
    }

    /**
     * Returns the current translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     PropelPDO $con an optional connection object
     *
     * @return CustomerTitleI18n */
    public function getTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collCustomerTitleI18ns) {
                foreach ($this->collCustomerTitleI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new CustomerTitleI18n();
                $translation->setLocale($locale);
            } else {
                $translation = CustomerTitleI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addCustomerTitleI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     PropelPDO $con an optional connection object
     *
     * @return    CustomerTitle The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!$this->isNew()) {
            CustomerTitleI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collCustomerTitleI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collCustomerTitleI18ns[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Returns the current translation
     *
     * @param     PropelPDO $con an optional connection object
     *
     * @return CustomerTitleI18n */
    public function getCurrentTranslation(PropelPDO $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [short] column value.
         *
         * @return string
         */
        public function getShort()
        {
        return $this->getCurrentTranslation()->getShort();
    }


        /**
         * Set the value of [short] column.
         *
         * @param string $v new value
         * @return CustomerTitleI18n The current object (for fluent API support)
         */
        public function setShort($v)
        {    $this->getCurrentTranslation()->setShort($v);

        return $this;
    }


        /**
         * Get the [long] column value.
         *
         * @return string
         */
        public function getLong()
        {
        return $this->getCurrentTranslation()->getLong();
    }


        /**
         * Set the value of [long] column.
         *
         * @param string $v new value
         * @return CustomerTitleI18n The current object (for fluent API support)
         */
        public function setLong($v)
        {    $this->getCurrentTranslation()->setLong($v);

        return $this;
    }

}
