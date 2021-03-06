<?php

namespace Thelia\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'attribute_combination' table.
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
class AttributeCombinationTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Thelia.Model.map.AttributeCombinationTableMap';

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
        $this->setName('attribute_combination');
        $this->setPhpName('AttributeCombination');
        $this->setClassname('Thelia\\Model\\AttributeCombination');
        $this->setPackage('Thelia.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignPrimaryKey('attribute_id', 'AttributeId', 'INTEGER' , 'attribute', 'id', true, null, null);
        $this->addForeignPrimaryKey('combination_id', 'CombinationId', 'INTEGER' , 'combination', 'id', true, null, null);
        $this->addForeignPrimaryKey('attribute_av_id', 'AttributeAvId', 'INTEGER' , 'attribute_av', 'id', true, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Attribute', 'Thelia\\Model\\Attribute', RelationMap::MANY_TO_ONE, array('attribute_id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('AttributeAv', 'Thelia\\Model\\AttributeAv', RelationMap::MANY_TO_ONE, array('attribute_av_id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('Combination', 'Thelia\\Model\\Combination', RelationMap::MANY_TO_ONE, array('combination_id' => 'id', ), 'CASCADE', 'RESTRICT');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' =>  array (
  'create_column' => 'created_at',
  'update_column' => 'updated_at',
  'disable_updated_at' => 'false',
),
        );
    } // getBehaviors()

} // AttributeCombinationTableMap
