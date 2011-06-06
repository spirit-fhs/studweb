<?php
/**
 * Entry data mapper
 *
 * Implements the Data Mapper design pattern:
 * http://www.martinfowler.com/eaaCatalog/dataMapper.html
 * 
 * @uses       Default_Model_DbTable_Entry
 * @package    Default
 * @subpackage Model
 */
class Default_Model_Mapper_EntryDbMapper
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Default_Model_Mapper_EntryDbMapper
     */
    public function setDbTable ($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (! $dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    /**
     * Get registered Zend_Db_Table instance
     *
     * Lazy loads Default_Model_DbTable_Entry if no instance registered
     * 
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Default_Model_DbTable_Entry');
        }
        return $this->_dbTable;
    }
    /**
     * Find a entry by id
     * 
     * @param  int $id 
     * @param  Default_Model_Entry $entry 
     * @uses   Default_Model_Comment $comment,$comments
     * @return void
     */
    public function find ($news_id, Default_Model_Entry $entry)
    {
        $result = $this->getDbTable()->find((int)$news_id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        
        $comment = new Default_Model_Comment();
        $comments = $comment->fetchAll($row->news_id);
        
    	// hook to filter with class
    	// because REST provides an array with objects 
    	$class = new Default_Model_Class();
    	$class->setClass_id($row->classes)
    	      ->setTitle($row->class_title);
    	
        $entry->setNews_id($row->news_id)
            ->setTitle($row->title)
            ->setContent($row->content)
            ->setCreationDate($row->creationDate)
            ->setOwner($row->owner)
            ->setDisplayedName($row->displayedName)
            ->setClasses(array($class))
            ->setComments($comments);
    }
    /**
     * Fetch all entries
     * 
     * @uses   Default_Model_Comment $comment,$comments
     * @return array
     */
    public function fetchAll (array $filterParams = array())
    {
        $table = $this->getDbTable();
        $filterParamsDb = array();
        foreach ($filterParams as $k => $v) {
            $filterParamsDb[$k . ' = ?'] = $v;
        }
        $resultSet = $table->fetchAll($filterParamsDb);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Default_Model_Entry();
            $comment = new Default_Model_Comment();
        	$comments = $comment->fetchAll($row->news_id);
            
        	// hook to filter with class
        	// because REST provides an array with objects 
        	$class = new Default_Model_Class();
        	$class->setClass_id($row->classes)
        	      ->setTitle($row->class_title);
        	
        	$entry->setNews_id($row->news_id)
                ->setTitle($row->title)
                ->setContent($row->content)
                ->setCreationDate($row->creationDate)
                ->setOwner($row->owner)
                ->setDisplayedName($row->displayedName)
                ->setClasses(array($class))
                ->setComments($comments);
            $entries[] = $entry;
        }
        return $entries;
    }
}
