<?php
/**
 * Class data mapper
 *
 * Implements the Data Mapper design pattern:
 * http://www.martinfowler.com/eaaCatalog/dataMapper.html
 * 
 * @uses       Default_Service_Spirit
 * @package    Default
 * @subpackage Model
 */
class Default_Model_Mapper_ClassRestMapper
{
    /**
     * @var Default_Service_Spirit
     */
    protected $_service;
    /**
     * Specify Default_Service_Spirit instance to use for data operations
     * 
     * @param  Default_Service_Spirit $service 
     * @return Default_Model_Mapper_ClassRestMapper
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
     * Fetch all appointments
     * 
     * @uses   Default_Service_Spirit
     * @return array
     */
    public function fetchAll (array $params = array())
    {
        $params['responseType'] = 'json';
        $response = $this->getService()->fetchAllDegreeClasses($params);

        if(isset($response->error))
            return;
        $resultSet = $response->degreeClass;
        $classes = array();

        foreach ($resultSet as $row) {
          
            //convert event degreeClass to Default_Model_Class
            $class = new Default_Model_Class();
            $class->setClass_id($row->class_id)
                ->setTitle($row->title)
                ->setMail($row->mail)
                ->setClassType($row->classType)
                ->setParent_id($row->parent_id);
                // TODO add subClasses
            $classes[] = $class;
        }
        return $classes;
    }
    /**
     * find one class
     * 
     * @param  int $id 
     * @param  Default_Model_Class $class 
     * @uses   Default_Service_Spirit
     * @return void
     */
    public function find ($id, Default_Model_Class $class)
    {
        $params['responseType'] = 'json';
        $response = $this->getService()->fetchDegreeClass($id, $params);

        if(isset($response->error))
            return;
        $row = $response->degreeClass;

        
            //convert event degreeClass to Default_Model_Class
            $class->setClass_id($row[0]->class_id)
                ->setTitle($row[0]->title)
                ->setMail($row[0]->mail)
                ->setClassType($row[0]->classType)
                ->setParent_id($row[0]->parent_id);
                // TODO add subClasses
    }
}
?>