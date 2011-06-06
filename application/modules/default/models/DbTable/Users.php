<?php
/**
 * User table data gateway
 * 
 * @uses   Zend_Db_Table_Abstract
 * @author Florian Schuhmann
 * @package    Default
 * @subpackage DbTable 
 */
class Default_Model_DbTable_Users extends Zend_Db_Table_Abstract
{
    /**
     * @var string Name of the database table
     */
    protected $_name = 'users';
}
