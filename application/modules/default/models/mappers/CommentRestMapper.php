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
        if (! $service instanceof Application_Rest_Client) {
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
        $params = array('responseType' => 'json');
        $result = $this->getService()->findComment((int)$id,$params)->newsComment;

        // check if news available
        if (0 == count($result)) {
            return;
        }

        //convert classes from stdClass to Default_Model_Owner
        $owner = new Default_Model_Owner();
    	$owner->setFhs_id($result[0]->owner->fhs_id)
    	    ->setDisplayedName($result[0]->owner->displayedName)
    	    ->setMemberType($result[0]->owner->memberType); 

        $comment->setComment_id($result[0]->comment_id)
        	->setNews_id($result[0]->news->news_id)
            ->setContent($result[0]->content)
            ->setCreationDate($result[0]->creationDate)
            ->setOwner($owner);
    }
    /**
     * Save a comment
     * 
     * @param  Default_Model_Comment $comment 
     * @return void
     */
    public function save (Default_Model_Comment $comment)
    {
        $data = array("newsComment" => array(
        	'content' => $comment->getContent(),
            //'creationDate' => date('Y-m-d H:i:s'), // will be set by the REST-service
            'news' => array ('news_id' => (int)$comment->getNews_id()),
            'owner' => array ( "fhs_id" => $comment->getOwner()->getFhs_id()) // this fhs_id musst be in the DB! or no comment will saved
        ));
        
        $params = array('responseType' => 'json',
            'data' => Zend_Json_Encoder::encode($data),
            'encryptType' => 'json'
        );
        if (null === ($id = $comment->getComment_id())) {
            unset($data['comment_id']);
            $this->getService()->saveComment($params);
        }
    }
    /**
     * Delete comment
     * 
     * @return array
     */
    public function delete ($where)
    {
        $params = array('responseType' => 'json');
        $resultSet = $this->getService()->deleteComment($where, $params);

        return $resultSet;
    }
}
