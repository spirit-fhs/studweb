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
class Default_Model_EntryRestMapper
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
        $result = $this->getService()->findNews((int)$id,$params);

        // check if news available
        if (0 == count($result)) {
            return;
        }

        //convert comments to Default_Model_Comment
        $comments = array();
        foreach($result[0]->newsComments as $values){
            $comment = new Default_Model_Comment();
            $comment->setContent($values->content)
                    ->setCreationDate($values->creationDate)
                    ->setEntryId($result[0]->news_id)
                    ->setId($values->id)
                    //->setOwner($values->owner)
                    ->setDisplayedName($values->displayedName);
            $comments[] = $comment; 
        }
        
        //convert classes from stdClass to string
        /*$classes ='';
        foreach ($result[0]->classes as $class){
            $classes .= $class->title . ' ';
        }*/
        //put all in the $entry
        $entry->setNews_id($result[0]->news_id)
            ->setTitle($result[0]->title)
            ->setContent($result[0]->content)
            ->setCreationDate($result[0]->creationDate)
            ->setOwner($result[0]->owner)
            ->setDisplayedName($result[0]->displayedName)
            ->setClasses($result[0]->classes)
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
        $resultSet = $this->getService()->fetchAllNews($filterParams,$params);
        $entries = array();

        foreach ($resultSet as $row) {
            $entry = new Default_Model_Entry();
            
            //convert comments to Default_Model_Comment
            $comments = array();
            foreach($row->newsComments as $values){
                $comment = new Default_Model_Comment();
                $comment->setContent($values->content)
                        ->setCreationDate($values->creationDate)
                        ->setEntryId($row->news_id)
                        ->setId($values->id)
                        //->setOwner($values->owner)
                        ->setDisplayedName($values->displayedName);
                $comments[] = $comment; 
            }

            //convert classes from stdClass to string
            /*$classes ='';
            foreach ($row->classes as $class){
                $classes .= $class->title . ' ';
            }*/
            
            //put all in the $entry
            $entry->setNews_id($row->news_id)
                ->setTitle($row->title)
                ->setContent($row->content)
                ->setCreationDate($row->creationDate)
                ->setOwner($row->owner)
                ->setDisplayedName($row->displayedName)
                //->setClasses($classes)
                ->setClasses($row->classes)
                ->setComments($comments);
            $entries[] = $entry;
            
        }
        return $entries;
    }
}
