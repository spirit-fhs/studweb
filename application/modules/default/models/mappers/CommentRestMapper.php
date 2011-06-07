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
class Default_Model_Mapper_CommentRestMapper
{
    /**
     * @var Default_Service_Spirit
     */
    protected $_service;
    /**
     * Specify Default_Service_Spirit instance to use for data operations
     * 
     * @param  Default_Service_Spirit $service 
     * @return Default_Model_Mapper_CommentRestMapper
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

        //convert classes from stdClass to Default_Model_Owner
        $owner = new Default_Model_Owner();
    	$owner->setFhs_id($result->owner)->setDisplayedName($result->displayedName); 

        $comment->setComment_id($result[0]->comment_id)
        	->setNews_id($result[0]->news_id)
            ->setContent($result[0]->content)
            ->setCreationDate($result[0]->creationDate)
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
            //convert classes from stdClass to Default_Model_Owner
            $owner = new Default_Model_Owner();
        	$owner->setFhs_id($result->owner)->setDisplayedName($result->displayedName); 

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
}
