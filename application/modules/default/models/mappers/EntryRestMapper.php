<?php
/**
 * Entry data mapper
 *
 * Implements the Data Mapper design pattern:
 * http://www.martinfowler.com/eaaCatalog/dataMapper.html
 * 
 * @uses       Default_Service_Spirit
 * @package    Default
 * @subpackage Model
 */
class Default_Model_Mapper_EntryRestMapper
{
    /**
     * @var Default_Service_Spirit
     */
    protected $_service;
    /**
     * Specify Default_Service_Spirit instance to use for data operations
     * 
     * @param  Default_Service_Spirit $service 
     * @return Default_Model_Mapper_EntryRestMapper
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
     * Find a entry by id
     * 
     * @param  int $id 
     * @param  Default_Model_Entry $entry 
     * @uses   Default_Service_Spirit $comment,$comments
     * @return void
     */
    public function find ($id, Default_Model_Entry $entry)
    {
        $params = array('type'=>'json');
        $result = $this->getService()->findNews((int)$id,$params)->news;

        // check if news available
        if (0 == count($result)) {
            return;
        }

        //convert comments to Default_Model_Comment
        $comments = array();
        foreach($result[0]->newsComment as $values){
            //convert classes from stdClass to Default_Model_Owner
            $owner = new Default_Model_Owner();
        	$owner->setFhs_id($values->owner->fhs_id)->setDisplayedName($values->owner->displayedName); 
              
            $comment = new Default_Model_Comment();
            $comment->setContent($values->content)
                    ->setCreationDate($values->creationDate)
                    ->setNews_id($result[0]->news_id)
                    ->setComment_id($values->comment_id)
                    ->setOwner($owner);
            $comments[] = $comment; 
        }
        
        //convert classes from stdClass to Default_Model_Class
        $classes = array();
        foreach ($result[0]->degreeClass as $class){
            $c = new Default_Model_Class();
            $c->setClass_id($class->class_id)->setTitle($class->title)->setMail($class->mail);
            $classes[] = $c;
        }
        //convert classes from stdClass to Default_Model_Owner
        $owner = new Default_Model_Owner();
    	$owner->setFhs_id($result[0]->owner->fhs_id)->setDisplayedName($result[0]->owner->displayedName); 
        	
        //put all in the $entry
        $entry->setNews_id($result[0]->news_id)
            ->setTitle($result[0]->title)
            ->setContent($result[0]->content)
            ->setCreationDate($result[0]->creationDate)
            ->setOwner($owner)
            ->setdegreeClass($classes)
            ->setComments($comments);
    }
    /**
     * Fetch all entries
     * 
     * @uses   Default_Service_Spirit $comment,$comments
     * @return array
     */
    public function fetchAll (array $filterParams = array())
    {
        $params = array('type'=>'json');
        $resultSet = $this->getService()->fetchAllNews($filterParams,$params)->news;
        $entries = array();

        foreach ($resultSet as $row) {
            $entry = new Default_Model_Entry();
            
            //convert comments to Default_Model_Comment
            $comments = array();
            foreach($row->newsComment as $values){
                //convert classes from stdClass to Default_Model_Owner
                $owner = new Default_Model_Owner();
            	$owner->setFhs_id($values->owner->fhs_id)->setDisplayedName($values->owner->displayedName); 
                    
                $comment = new Default_Model_Comment();
                $comment->setContent($values->content)
                        ->setCreationDate($values->creationDate)
                        ->setNews_id($row->news_id)
                        ->setComment_id($values->comment_id)
                        ->setOwner($owner);
                $comments[] = $comment; 
            }

            //convert classes from stdClass to Default_Model_Class
            $classes = array();
            foreach ($row->degreeClass as $class){
                $c = new Default_Model_Class();
                $c->setClass_id($class->class_id)->setTitle($class->title)->setMail($class->mail);
                $classes[] = $c;
            }
            
            //convert classes from stdClass to Default_Model_Owner
            $owner = new Default_Model_Owner();
        	$owner->setFhs_id($row->owner->fhs_id)->setDisplayedName($row->owner->displayedName); 

        	//put all in the $entry
            $entry->setNews_id($row->news_id)
                ->setTitle($row->title)
                ->setContent($row->content)
                ->setCreationDate($row->creationDate)
                ->setOwner($owner)
                ->setdegreeClass($classes)
                ->setComments($comments);
            $entries[] = $entry;
            
        }
        return $entries;
    }
}
