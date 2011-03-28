<?php
/**
 * Comment data mapper
 *
 * Implements the Data Mapper design pattern:
 * http://www.martinfowler.com/eaaCatalog/dataMapper.html
 * 
 * @uses       Default_Model_DbTable_Comment
 * @package    Default
 * @subpackage Model
 */
class Default_Model_CommentMapper
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Default_Model_CommentMapper
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
     * Lazy loads Default_Model_DbTable_Comment if no instance registered
     * 
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Default_Model_DbTable_Comment');
        }
        return $this->_dbTable;
    }
    /**
     * Save a comment
     * 
     * @param  Default_Model_Comment $comment 
     * @return void
     */
    public function save (Default_Model_Comment $comment)
    {
        $data = array('comment' => $comment->getComment(), 'user' => $comment->getUser(), 
        'crdate' => date('d.m.Y'), 'entryId' => $comment->getEntryId());
        if (null === ($id = $comment->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
    /**
     * Find a comment by id
     * 
     * @param  int $id 
     * @param  Default_Model_Comment $comment 
     * @return void
     */
    public function find ($id, Default_Model_Comment $comment)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $comment->setId($row->id)
        	->setEntryId($row->entryId)
            ->setComment($row->comment)
            ->setCrdate($row->crdate)
            ->setUser($row->user);
    }
    /**
     * Fetch all comments
     * 
     * @return array
     */
    public function fetchAll ($where)
    {
        $resultSet = $this->getDbTable()->fetchAll($where);
        $comments = array();
        foreach ($resultSet as $row) {
            $comment = new Default_Model_Comment();
            $comment->setId($row->id)
            	->setEntryId($row->entryId)
                ->setComment($row->comment)
                ->setCrdate($row->crdate)
                ->setUser($row->user)
                ->setMapper($this);
            $comments[] = $comment;
        }
        return $comments;
    }
}
