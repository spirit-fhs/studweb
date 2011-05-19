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
class Default_Model_CommentRestMapper
{
    /**
     * @var Default_Service_Spirit
     */
    protected $_service;
    /**
     * Specify Default_Service_Spirit instance to use for data operations
     * 
     * @param  Default_Service_Spirit $service 
     * @return Default_Model_EntryRestMapper
     */
    public function setService ($service)
    {
        if (is_string($service)) {
            $service = new $service();
        }
        if (! $service instanceof Zend_Rest_Client) {
            throw new Exception('Invalid data gateway provided');
        }
        $this->_service = $service;
        return $this;
    }
    /**
     * Get registered Default_Service_Spirit instance
     *
     * Lazy loads Default_Service_Spirit if no instance registered
     * 
     * @return Default_Service_Spirit
     */
    public function getService ()
    {
        if (null === $this->_service) {
            $this->setService('Default_Service_Spirit');
        }
        return $this->_service;
    }
    /**
     * Save a comment
     * 
     * @param  Default_Model_Comment $comment 
     * @return void
     */
    public function save (Default_Model_Comment $comment)
    {
        $data = array('content' => $comment->getContent(), 'owner' => $comment->getOwner(), 
        'creationDate' => date('d.m.Y'), 'entryId' => $comment->getEntryId());
        
        $params = array('type'=>'json');
        
        if (null === ($id = $comment->getId())) {
            unset($data['id']);
            
            $this->getService()->saveComment($data, $params);
        } else {
            $this->getService()->updateComment($data, array('id' => $id), $params);
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
        $params = array('type'=>'json');
        $result = $this->getService()->findComment((int)$id,$params);

        // check if news available
        if (0 == count($result)) {
            return;
        }
        
        $comment->setId($result[0]->id)
        	->setEntryId($result[0]->entryId)
            ->setContent($result[0]->content)
            ->setCreationDate($result[0]->creationDate)
            ->setOwner($result[0]->owner)
            ->setDisplayedName($result[0]->displayedName);
    }
    /**
     * Fetch all comments
     * 
     * @return array
     */
    public function fetchAll ($where)
    {
        $where = $this->getDbTable()->getAdapter()->quoteInto('entryId=?', (int)$where,'SQLT_INT');
        $resultSet = $this->getDbTable()->fetchAll($where);
        $comments = array();
        foreach ($resultSet as $row) {
            $comment = new Default_Model_Comment();
            $comment->setId($row->id)
            	->setEntryId($row->entryId)
                ->setContent($row->content)
                ->setCreationDate($row->creationDate)
                ->setOwner($row->owner)
                ->setDisplayedName($row->displayedName)
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
        $where = $this->getDbTable()->getAdapter()->quoteInto('id=?', (int)$where,'SQLT_INT');
        $resultSet = $this->getDbTable()->delete($where);

        return $resultSet;
    }    
}
