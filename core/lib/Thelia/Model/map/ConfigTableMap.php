<?php

namespace Thelia\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'config' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.Thelia.Model.map
 */
class ConfigTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Thelia.Model.map.ConfigTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('config');
        $this->setPhpName('Config');
        $this->setClassname('Thelia\\Model\\Config');
        $this->setPackage('Thelia.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addForeignPrimaryKey('ID', 'Id', 'INTEGER' , 'config_desc', 'CONFIG_ID', true, null, null);
        $this->addColumn('NAME', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('VALUE', 'Value', 'VARCHAR', true, 255, null);
        $this->addColumn('SECURE', 'Secure', 'TINYINT', true, null, 1);
        $this->addColumn('HIDDEN', 'Hidden', 'TINYINT', true, null, 1);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', true, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ConfigDesc', 'Thelia\\Model\\ConfigDesc', RelationMap::MANY_TO_ONE, array('id' => 'config_id', ), 'CASCADE', 'RESTRICT');
    } // buildRelations()

} // ConfigTableMap
