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
use Thelia\Model\Area;
use Thelia\Model\AreaQuery;
use Thelia\Model\Country;
use Thelia\Model\CountryI18n;
use Thelia\Model\CountryI18nQuery;
use Thelia\Model\CountryPeer;
use Thelia\Model\CountryQuery;
use Thelia\Model\TaxRuleCountry;
use Thelia\Model\TaxRuleCountryQuery;

/**
 * Base class that represents a row from the 'country' table.
 *
 *
 *
 * @package    propel.generator.Thelia.Model.om
 */
abstract class BaseCountry extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Thelia\\Model\\CountryPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        CountryPeer
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
     * The value for the area_id field.
     * @var        int
     */
    protected $area_id;

    /**
     * The value for the isocode field.
     * @var        string
     */
    protected $isocode;

    /**
     * The value for the isoalpha2 field.
     * @var        string
     */
    protected $isoalpha2;

    /**
     * The value for the isoalpha3 field.
     * @var        string
     */
    protected $isoalpha3;

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
     * @var        Area
     */
    protected $aArea;

    /**
     * @var        PropelObjectCollection|TaxRuleCountry[] Collection to store aggregation of TaxRuleCountry objects.
     */
    protected $collTaxRuleCountrys;
    protected $collTaxRuleCountrysPartial;

    /**
     * @var        PropelObjectCollection|CountryI18n[] Collection to store aggregation of CountryI18n objects.
     */
    protected $collCountryI18ns;
    protected $collCountryI18nsPartial;

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
     * @var        array[CountryI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $taxRuleCountrysScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $countryI18nsScheduledForDeletion = null;

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
     * Get the [area_id] column value.
     *
     * @return int
     */
    public function getAreaId()
    {
        return $this->area_id;
    }

    /**
     * Get the [isocode] column value.
     *
     * @return string
     */
    public function getIsocode()
    {
        return $this->isocode;
    }

    /**
     * Get the [isoalpha2] column value.
     *
     * @return string
     */
    public function getIsoalpha2()
    {
        return $this->isoalpha2;
    }

    /**
     * Get the [isoalpha3] column value.
     *
     * @return string
     */
    public function getIsoalpha3()
    {
        return $this->isoalpha3;
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
     * @return Country The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = CountryPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [area_id] column.
     *
     * @param int $v new value
     * @return Country The current object (for fluent API support)
     */
    public function setAreaId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->area_id !== $v) {
            $this->area_id = $v;
            $this->modifiedColumns[] = CountryPeer::AREA_ID;
        }

        if ($this->aArea !== null && $this->aArea->getId() !== $v) {
            $this->aArea = null;
        }


        return $this;
    } // setAreaId()

    /**
     * Set the value of [isocode] column.
     *
     * @param string $v new value
     * @return Country The current object (for fluent API support)
     */
    public function setIsocode($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->isocode !== $v) {
            $this->isocode = $v;
            $this->modifiedColumns[] = CountryPeer::ISOCODE;
        }


        return $this;
    } // setIsocode()

    /**
     * Set the value of [isoalpha2] column.
     *
     * @param string $v new value
     * @return Country The current object (for fluent API support)
     */
    public function setIsoalpha2($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->isoalpha2 !== $v) {
            $this->isoalpha2 = $v;
            $this->modifiedColumns[] = CountryPeer::ISOALPHA2;
        }


        return $this;
    } // setIsoalpha2()

    /**
     * Set the value of [isoalpha3] column.
     *
     * @param string $v new value
     * @return Country The current object (for fluent API support)
     */
    public function setIsoalpha3($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->isoalpha3 !== $v) {
            $this->isoalpha3 = $v;
            $this->modifiedColumns[] = CountryPeer::ISOALPHA3;
        }


        return $this;
    } // setIsoalpha3()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Country The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = CountryPeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Country The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            $currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->updated_at = $newDateAsString;
                $this->modifiedColumns[] = CountryPeer::UPDATED_AT;
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
            $this->area_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->isocode = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->isoalpha2 = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->isoalpha3 = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->created_at = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->updated_at = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 7; // 7 = CountryPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Country object", $e);
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

        if ($this->aArea !== null && $this->area_id !== $this->aArea->getId()) {
            $this->aArea = null;
        }
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
            $con = Propel::getConnection(CountryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = CountryPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aArea = null;
            $this->collTaxRuleCountrys = null;

            $this->collCountryI18ns = null;

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
            $con = Propel::getConnection(CountryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = CountryQuery::create()
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
            $con = Propel::getConnection(CountryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(CountryPeer::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(CountryPeer::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(CountryPeer::UPDATED_AT)) {
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
                CountryPeer::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aArea !== null) {
                if ($this->aArea->isModified() || $this->aArea->isNew()) {
                    $affectedRows += $this->aArea->save($con);
                }
                $this->setArea($this->aArea);
            }

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

            if ($this->taxRuleCountrysScheduledForDeletion !== null) {
                if (!$this->taxRuleCountrysScheduledForDeletion->isEmpty()) {
                    foreach ($this->taxRuleCountrysScheduledForDeletion as $taxRuleCountry) {
                        // need to save related object because we set the relation to null
                        $taxRuleCountry->save($con);
                    }
                    $this->taxRuleCountrysScheduledForDeletion = null;
                }
            }

            if ($this->collTaxRuleCountrys !== null) {
                foreach ($this->collTaxRuleCountrys as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->countryI18nsScheduledForDeletion !== null) {
                if (!$this->countryI18nsScheduledForDeletion->isEmpty()) {
                    CountryI18nQuery::create()
                        ->filterByPrimaryKeys($this->countryI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->countryI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collCountryI18ns !== null) {
                foreach ($this->collCountryI18ns as $referrerFK) {
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CountryPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(CountryPeer::AREA_ID)) {
            $modifiedColumns[':p' . $index++]  = '`area_id`';
        }
        if ($this->isColumnModified(CountryPeer::ISOCODE)) {
            $modifiedColumns[':p' . $index++]  = '`isocode`';
        }
        if ($this->isColumnModified(CountryPeer::ISOALPHA2)) {
            $modifiedColumns[':p' . $index++]  = '`isoalpha2`';
        }
        if ($this->isColumnModified(CountryPeer::ISOALPHA3)) {
            $modifiedColumns[':p' . $index++]  = '`isoalpha3`';
        }
        if ($this->isColumnModified(CountryPeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(CountryPeer::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `country` (%s) VALUES (%s)',
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
                    case '`area_id`':
                        $stmt->bindValue($identifier, $this->area_id, PDO::PARAM_INT);
                        break;
                    case '`isocode`':
                        $stmt->bindValue($identifier, $this->isocode, PDO::PARAM_STR);
                        break;
                    case '`isoalpha2`':
                        $stmt->bindValue($identifier, $this->isoalpha2, PDO::PARAM_STR);
                        break;
                    case '`isoalpha3`':
                        $stmt->bindValue($identifier, $this->isoalpha3, PDO::PARAM_STR);
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


            // We call the validate method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aArea !== null) {
                if (!$this->aArea->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aArea->getValidationFailures());
                }
            }


            if (($retval = CountryPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collTaxRuleCountrys !== null) {
                    foreach ($this->collTaxRuleCountrys as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCountryI18ns !== null) {
                    foreach ($this->collCountryI18ns as $referrerFK) {
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
        $pos = CountryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getAreaId();
                break;
            case 2:
                return $this->getIsocode();
                break;
            case 3:
                return $this->getIsoalpha2();
                break;
            case 4:
                return $this->getIsoalpha3();
                break;
            case 5:
                return $this->getCreatedAt();
                break;
            case 6:
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
        if (isset($alreadyDumpedObjects['Country'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Country'][$this->getPrimaryKey()] = true;
        $keys = CountryPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getAreaId(),
            $keys[2] => $this->getIsocode(),
            $keys[3] => $this->getIsoalpha2(),
            $keys[4] => $this->getIsoalpha3(),
            $keys[5] => $this->getCreatedAt(),
            $keys[6] => $this->getUpdatedAt(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aArea) {
                $result['Area'] = $this->aArea->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collTaxRuleCountrys) {
                $result['TaxRuleCountrys'] = $this->collTaxRuleCountrys->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCountryI18ns) {
                $result['CountryI18ns'] = $this->collCountryI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = CountryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setAreaId($value);
                break;
            case 2:
                $this->setIsocode($value);
                break;
            case 3:
                $this->setIsoalpha2($value);
                break;
            case 4:
                $this->setIsoalpha3($value);
                break;
            case 5:
                $this->setCreatedAt($value);
                break;
            case 6:
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
        $keys = CountryPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setAreaId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setIsocode($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setIsoalpha2($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setIsoalpha3($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setUpdatedAt($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CountryPeer::DATABASE_NAME);

        if ($this->isColumnModified(CountryPeer::ID)) $criteria->add(CountryPeer::ID, $this->id);
        if ($this->isColumnModified(CountryPeer::AREA_ID)) $criteria->add(CountryPeer::AREA_ID, $this->area_id);
        if ($this->isColumnModified(CountryPeer::ISOCODE)) $criteria->add(CountryPeer::ISOCODE, $this->isocode);
        if ($this->isColumnModified(CountryPeer::ISOALPHA2)) $criteria->add(CountryPeer::ISOALPHA2, $this->isoalpha2);
        if ($this->isColumnModified(CountryPeer::ISOALPHA3)) $criteria->add(CountryPeer::ISOALPHA3, $this->isoalpha3);
        if ($this->isColumnModified(CountryPeer::CREATED_AT)) $criteria->add(CountryPeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(CountryPeer::UPDATED_AT)) $criteria->add(CountryPeer::UPDATED_AT, $this->updated_at);

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
        $criteria = new Criteria(CountryPeer::DATABASE_NAME);
        $criteria->add(CountryPeer::ID, $this->id);

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
     * @param object $copyObj An object of Country (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAreaId($this->getAreaId());
        $copyObj->setIsocode($this->getIsocode());
        $copyObj->setIsoalpha2($this->getIsoalpha2());
        $copyObj->setIsoalpha3($this->getIsoalpha3());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getTaxRuleCountrys() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTaxRuleCountry($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCountryI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCountryI18n($relObj->copy($deepCopy));
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
     * @return Country Clone of current object.
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
     * @return CountryPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new CountryPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Area object.
     *
     * @param             Area $v
     * @return Country The current object (for fluent API support)
     * @throws PropelException
     */
    public function setArea(Area $v = null)
    {
        if ($v === null) {
            $this->setAreaId(NULL);
        } else {
            $this->setAreaId($v->getId());
        }

        $this->aArea = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Area object, it will not be re-added.
        if ($v !== null) {
            $v->addCountry($this);
        }


        return $this;
    }


    /**
     * Get the associated Area object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Area The associated Area object.
     * @throws PropelException
     */
    public function getArea(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aArea === null && ($this->area_id !== null) && $doQuery) {
            $this->aArea = AreaQuery::create()->findPk($this->area_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aArea->addCountrys($this);
             */
        }

        return $this->aArea;
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
        if ('TaxRuleCountry' == $relationName) {
            $this->initTaxRuleCountrys();
        }
        if ('CountryI18n' == $relationName) {
            $this->initCountryI18ns();
        }
    }

    /**
     * Clears out the collTaxRuleCountrys collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Country The current object (for fluent API support)
     * @see        addTaxRuleCountrys()
     */
    public function clearTaxRuleCountrys()
    {
        $this->collTaxRuleCountrys = null; // important to set this to null since that means it is uninitialized
        $this->collTaxRuleCountrysPartial = null;

        return $this;
    }

    /**
     * reset is the collTaxRuleCountrys collection loaded partially
     *
     * @return void
     */
    public function resetPartialTaxRuleCountrys($v = true)
    {
        $this->collTaxRuleCountrysPartial = $v;
    }

    /**
     * Initializes the collTaxRuleCountrys collection.
     *
     * By default this just sets the collTaxRuleCountrys collection to an empty array (like clearcollTaxRuleCountrys());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTaxRuleCountrys($overrideExisting = true)
    {
        if (null !== $this->collTaxRuleCountrys && !$overrideExisting) {
            return;
        }
        $this->collTaxRuleCountrys = new PropelObjectCollection();
        $this->collTaxRuleCountrys->setModel('TaxRuleCountry');
    }

    /**
     * Gets an array of TaxRuleCountry objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Country is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|TaxRuleCountry[] List of TaxRuleCountry objects
     * @throws PropelException
     */
    public function getTaxRuleCountrys($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collTaxRuleCountrysPartial && !$this->isNew();
        if (null === $this->collTaxRuleCountrys || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTaxRuleCountrys) {
                // return empty collection
                $this->initTaxRuleCountrys();
            } else {
                $collTaxRuleCountrys = TaxRuleCountryQuery::create(null, $criteria)
                    ->filterByCountry($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collTaxRuleCountrysPartial && count($collTaxRuleCountrys)) {
                      $this->initTaxRuleCountrys(false);

                      foreach($collTaxRuleCountrys as $obj) {
                        if (false == $this->collTaxRuleCountrys->contains($obj)) {
                          $this->collTaxRuleCountrys->append($obj);
                        }
                      }

                      $this->collTaxRuleCountrysPartial = true;
                    }

                    $collTaxRuleCountrys->getInternalIterator()->rewind();
                    return $collTaxRuleCountrys;
                }

                if($partial && $this->collTaxRuleCountrys) {
                    foreach($this->collTaxRuleCountrys as $obj) {
                        if($obj->isNew()) {
                            $collTaxRuleCountrys[] = $obj;
                        }
                    }
                }

                $this->collTaxRuleCountrys = $collTaxRuleCountrys;
                $this->collTaxRuleCountrysPartial = false;
            }
        }

        return $this->collTaxRuleCountrys;
    }

    /**
     * Sets a collection of TaxRuleCountry objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $taxRuleCountrys A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Country The current object (for fluent API support)
     */
    public function setTaxRuleCountrys(PropelCollection $taxRuleCountrys, PropelPDO $con = null)
    {
        $taxRuleCountrysToDelete = $this->getTaxRuleCountrys(new Criteria(), $con)->diff($taxRuleCountrys);

        $this->taxRuleCountrysScheduledForDeletion = unserialize(serialize($taxRuleCountrysToDelete));

        foreach ($taxRuleCountrysToDelete as $taxRuleCountryRemoved) {
            $taxRuleCountryRemoved->setCountry(null);
        }

        $this->collTaxRuleCountrys = null;
        foreach ($taxRuleCountrys as $taxRuleCountry) {
            $this->addTaxRuleCountry($taxRuleCountry);
        }

        $this->collTaxRuleCountrys = $taxRuleCountrys;
        $this->collTaxRuleCountrysPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TaxRuleCountry objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related TaxRuleCountry objects.
     * @throws PropelException
     */
    public function countTaxRuleCountrys(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collTaxRuleCountrysPartial && !$this->isNew();
        if (null === $this->collTaxRuleCountrys || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTaxRuleCountrys) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getTaxRuleCountrys());
            }
            $query = TaxRuleCountryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCountry($this)
                ->count($con);
        }

        return count($this->collTaxRuleCountrys);
    }

    /**
     * Method called to associate a TaxRuleCountry object to this object
     * through the TaxRuleCountry foreign key attribute.
     *
     * @param    TaxRuleCountry $l TaxRuleCountry
     * @return Country The current object (for fluent API support)
     */
    public function addTaxRuleCountry(TaxRuleCountry $l)
    {
        if ($this->collTaxRuleCountrys === null) {
            $this->initTaxRuleCountrys();
            $this->collTaxRuleCountrysPartial = true;
        }
        if (!in_array($l, $this->collTaxRuleCountrys->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddTaxRuleCountry($l);
        }

        return $this;
    }

    /**
     * @param	TaxRuleCountry $taxRuleCountry The taxRuleCountry object to add.
     */
    protected function doAddTaxRuleCountry($taxRuleCountry)
    {
        $this->collTaxRuleCountrys[]= $taxRuleCountry;
        $taxRuleCountry->setCountry($this);
    }

    /**
     * @param	TaxRuleCountry $taxRuleCountry The taxRuleCountry object to remove.
     * @return Country The current object (for fluent API support)
     */
    public function removeTaxRuleCountry($taxRuleCountry)
    {
        if ($this->getTaxRuleCountrys()->contains($taxRuleCountry)) {
            $this->collTaxRuleCountrys->remove($this->collTaxRuleCountrys->search($taxRuleCountry));
            if (null === $this->taxRuleCountrysScheduledForDeletion) {
                $this->taxRuleCountrysScheduledForDeletion = clone $this->collTaxRuleCountrys;
                $this->taxRuleCountrysScheduledForDeletion->clear();
            }
            $this->taxRuleCountrysScheduledForDeletion[]= $taxRuleCountry;
            $taxRuleCountry->setCountry(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Country is new, it will return
     * an empty collection; or if this Country has previously
     * been saved, it will retrieve related TaxRuleCountrys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Country.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|TaxRuleCountry[] List of TaxRuleCountry objects
     */
    public function getTaxRuleCountrysJoinTax($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TaxRuleCountryQuery::create(null, $criteria);
        $query->joinWith('Tax', $join_behavior);

        return $this->getTaxRuleCountrys($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Country is new, it will return
     * an empty collection; or if this Country has previously
     * been saved, it will retrieve related TaxRuleCountrys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Country.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|TaxRuleCountry[] List of TaxRuleCountry objects
     */
    public function getTaxRuleCountrysJoinTaxRule($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TaxRuleCountryQuery::create(null, $criteria);
        $query->joinWith('TaxRule', $join_behavior);

        return $this->getTaxRuleCountrys($query, $con);
    }

    /**
     * Clears out the collCountryI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Country The current object (for fluent API support)
     * @see        addCountryI18ns()
     */
    public function clearCountryI18ns()
    {
        $this->collCountryI18ns = null; // important to set this to null since that means it is uninitialized
        $this->collCountryI18nsPartial = null;

        return $this;
    }

    /**
     * reset is the collCountryI18ns collection loaded partially
     *
     * @return void
     */
    public function resetPartialCountryI18ns($v = true)
    {
        $this->collCountryI18nsPartial = $v;
    }

    /**
     * Initializes the collCountryI18ns collection.
     *
     * By default this just sets the collCountryI18ns collection to an empty array (like clearcollCountryI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCountryI18ns($overrideExisting = true)
    {
        if (null !== $this->collCountryI18ns && !$overrideExisting) {
            return;
        }
        $this->collCountryI18ns = new PropelObjectCollection();
        $this->collCountryI18ns->setModel('CountryI18n');
    }

    /**
     * Gets an array of CountryI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Country is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|CountryI18n[] List of CountryI18n objects
     * @throws PropelException
     */
    public function getCountryI18ns($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCountryI18nsPartial && !$this->isNew();
        if (null === $this->collCountryI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCountryI18ns) {
                // return empty collection
                $this->initCountryI18ns();
            } else {
                $collCountryI18ns = CountryI18nQuery::create(null, $criteria)
                    ->filterByCountry($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCountryI18nsPartial && count($collCountryI18ns)) {
                      $this->initCountryI18ns(false);

                      foreach($collCountryI18ns as $obj) {
                        if (false == $this->collCountryI18ns->contains($obj)) {
                          $this->collCountryI18ns->append($obj);
                        }
                      }

                      $this->collCountryI18nsPartial = true;
                    }

                    $collCountryI18ns->getInternalIterator()->rewind();
                    return $collCountryI18ns;
                }

                if($partial && $this->collCountryI18ns) {
                    foreach($this->collCountryI18ns as $obj) {
                        if($obj->isNew()) {
                            $collCountryI18ns[] = $obj;
                        }
                    }
                }

                $this->collCountryI18ns = $collCountryI18ns;
                $this->collCountryI18nsPartial = false;
            }
        }

        return $this->collCountryI18ns;
    }

    /**
     * Sets a collection of CountryI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $countryI18ns A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Country The current object (for fluent API support)
     */
    public function setCountryI18ns(PropelCollection $countryI18ns, PropelPDO $con = null)
    {
        $countryI18nsToDelete = $this->getCountryI18ns(new Criteria(), $con)->diff($countryI18ns);

        $this->countryI18nsScheduledForDeletion = unserialize(serialize($countryI18nsToDelete));

        foreach ($countryI18nsToDelete as $countryI18nRemoved) {
            $countryI18nRemoved->setCountry(null);
        }

        $this->collCountryI18ns = null;
        foreach ($countryI18ns as $countryI18n) {
            $this->addCountryI18n($countryI18n);
        }

        $this->collCountryI18ns = $countryI18ns;
        $this->collCountryI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CountryI18n objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related CountryI18n objects.
     * @throws PropelException
     */
    public function countCountryI18ns(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCountryI18nsPartial && !$this->isNew();
        if (null === $this->collCountryI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCountryI18ns) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCountryI18ns());
            }
            $query = CountryI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCountry($this)
                ->count($con);
        }

        return count($this->collCountryI18ns);
    }

    /**
     * Method called to associate a CountryI18n object to this object
     * through the CountryI18n foreign key attribute.
     *
     * @param    CountryI18n $l CountryI18n
     * @return Country The current object (for fluent API support)
     */
    public function addCountryI18n(CountryI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collCountryI18ns === null) {
            $this->initCountryI18ns();
            $this->collCountryI18nsPartial = true;
        }
        if (!in_array($l, $this->collCountryI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCountryI18n($l);
        }

        return $this;
    }

    /**
     * @param	CountryI18n $countryI18n The countryI18n object to add.
     */
    protected function doAddCountryI18n($countryI18n)
    {
        $this->collCountryI18ns[]= $countryI18n;
        $countryI18n->setCountry($this);
    }

    /**
     * @param	CountryI18n $countryI18n The countryI18n object to remove.
     * @return Country The current object (for fluent API support)
     */
    public function removeCountryI18n($countryI18n)
    {
        if ($this->getCountryI18ns()->contains($countryI18n)) {
            $this->collCountryI18ns->remove($this->collCountryI18ns->search($countryI18n));
            if (null === $this->countryI18nsScheduledForDeletion) {
                $this->countryI18nsScheduledForDeletion = clone $this->collCountryI18ns;
                $this->countryI18nsScheduledForDeletion->clear();
            }
            $this->countryI18nsScheduledForDeletion[]= clone $countryI18n;
            $countryI18n->setCountry(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->area_id = null;
        $this->isocode = null;
        $this->isoalpha2 = null;
        $this->isoalpha3 = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
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
            if ($this->collTaxRuleCountrys) {
                foreach ($this->collTaxRuleCountrys as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCountryI18ns) {
                foreach ($this->collCountryI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aArea instanceof Persistent) {
              $this->aArea->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'en_US';
        $this->currentTranslations = null;

        if ($this->collTaxRuleCountrys instanceof PropelCollection) {
            $this->collTaxRuleCountrys->clearIterator();
        }
        $this->collTaxRuleCountrys = null;
        if ($this->collCountryI18ns instanceof PropelCollection) {
            $this->collCountryI18ns->clearIterator();
        }
        $this->collCountryI18ns = null;
        $this->aArea = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CountryPeer::DEFAULT_STRING_FORMAT);
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
     * @return     Country The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[] = CountryPeer::UPDATED_AT;

        return $this;
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    Country The current object (for fluent API support)
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
     * @return CountryI18n */
    public function getTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collCountryI18ns) {
                foreach ($this->collCountryI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new CountryI18n();
                $translation->setLocale($locale);
            } else {
                $translation = CountryI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addCountryI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     PropelPDO $con an optional connection object
     *
     * @return    Country The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!$this->isNew()) {
            CountryI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collCountryI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collCountryI18ns[$key]);
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
     * @return CountryI18n */
    public function getCurrentTranslation(PropelPDO $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [title] column value.
         *
         * @return string
         */
        public function getTitle()
        {
        return $this->getCurrentTranslation()->getTitle();
    }


        /**
         * Set the value of [title] column.
         *
         * @param string $v new value
         * @return CountryI18n The current object (for fluent API support)
         */
        public function setTitle($v)
        {    $this->getCurrentTranslation()->setTitle($v);

        return $this;
    }


        /**
         * Get the [description] column value.
         *
         * @return string
         */
        public function getDescription()
        {
        return $this->getCurrentTranslation()->getDescription();
    }


        /**
         * Set the value of [description] column.
         *
         * @param string $v new value
         * @return CountryI18n The current object (for fluent API support)
         */
        public function setDescription($v)
        {    $this->getCurrentTranslation()->setDescription($v);

        return $this;
    }


        /**
         * Get the [chapo] column value.
         *
         * @return string
         */
        public function getChapo()
        {
        return $this->getCurrentTranslation()->getChapo();
    }


        /**
         * Set the value of [chapo] column.
         *
         * @param string $v new value
         * @return CountryI18n The current object (for fluent API support)
         */
        public function setChapo($v)
        {    $this->getCurrentTranslation()->setChapo($v);

        return $this;
    }


        /**
         * Get the [postscriptum] column value.
         *
         * @return string
         */
        public function getPostscriptum()
        {
        return $this->getCurrentTranslation()->getPostscriptum();
    }


        /**
         * Set the value of [postscriptum] column.
         *
         * @param string $v new value
         * @return CountryI18n The current object (for fluent API support)
         */
        public function setPostscriptum($v)
        {    $this->getCurrentTranslation()->setPostscriptum($v);

        return $this;
    }

}
