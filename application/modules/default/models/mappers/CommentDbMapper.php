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
class Default_Model_Mapper_CommentDbMapper
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Default_Model_Mapper_CommentMapper
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
        $data = array('content' => $comment->getContent(), 'owner' => $comment->getOwner()->getFhs_id(), 
        'creationDate' => date('d.m.Y'), 'news_id' => $comment->getNews_id(),
        'displayedName' =>$comment->getOwner()->getDisplayedName());
        if (null === ($id = $comment->getComment_id())) {
            unset($data['comment_id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('comment_id = ?' => $id));
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
        $result = $this->getDbTable()->find((int)$id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();

        // REST provides an owner object
    	// so the db must do this too
    	$owner = new Default_Model_Owner();
    	$owner->setFhs_id($row->owner)->setDisplayedName($row->displayedName); 

        $comment->setComment_id($row->comment_id)
        	->setNews_id($row->news_id)
            ->setContent($row->content)
            ->setCreationDate($row->creationDate)
            ->setOwner($owner);
    }
    /**
     * Fetch all comments
     * 
     * @return array
     */
    public function fetchAll ($where)
    {
        $where = $this->getDbTable()->getAdapter()->quoteInto('news_id=?', (int)$where,'SQLT_INT');
        $resultSet = $this->getDbTable()->fetchAll($where);
        $comments = array();
        foreach ($resultSet as $row) {
            // REST provides an owner object
        	// so the db must do this too
        	$owner = new Default_Model_Owner();
        	$owner->setFhs_id($row->owner)->setDisplayedName($row->displayedName); 
            
            $comment = new Default_Model_Comment();
            $comment->setComment_id($row->comment_id)
            	->setNews_id($row->news_id)
                ->setContent($row->content)
                ->setCreationDate($row->creationDate)
                ->setOwner($owner)
                ->setMapper($this);
            $comments[] = $comment;
        }
        return $comments;
    }
    /**
     * Delete comment
     * 
     * @return array
     */
    public function delete ($where)
    {
        $where = $this->getDbTable()->getAdapter()->quoteInto('comment_id=?', (int)$where,'SQLT_INT');
        $resultSet = $this->getDbTable()->delete($where);

        return $resultSet;
    }    
}
