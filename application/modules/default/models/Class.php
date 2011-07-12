<?php
/**
 * Class model
 *
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage Model
 */
class Default_Model_Class
{
    /**
     * @var int
     */
    protected $_class_id;
    /**
     * @var string
     */
    protected $_title;
    /**
     * @var string
     */
    protected $_mail;
    /**
     * @var string
     */
    protected $_classType;
    /**
     * @var array Default_Model_Class
     */
    protected $_subClasses;
    /**
     * @var Default_Model_Class
     */
    protected $_parent;
    /**
     * @var Default_Model_Mapper_ClassRestMapper
     */
    protected $_mapper;
    /**
     * Constructor
     * 
     * @param  array|null $options 
     * @return void
     */
    public function __construct (array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    /**
     * Overloading: allow property access
     * 
     * @param  string $name 
     * @param  mixed $value 
     * @return void
     */
    public function __set ($name, $value)
    {
        $method = 'set' . $name;
        if ('mapper' == $name || ! method_exists($this, $method)) {
            throw Exception('Invalid property specified');
        }
        $this->$method($value);
    }
    /**
     * Overloading: allow property access
     * 
     * @param  string $name 
     * @return mixed
     */
    public function __get ($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || ! method_exists($this, $method)) {
            throw Exception('Invalid property specified');
        }
        return $this->$method();
    }
    /**
     * Set object state
     * 
     * @param  array $options 
     * @return Default_Model_Class
     */
    public function setOptions (array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    /**
     * Set data mapper
     * 
     * @param  mixed $mapper 
     * @return Default_Model_Appointment
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * Get data mapper
     *
     * Lazy loads Default_Model_Mapper_ClassRestMapper instance if no mapper registered.
     * 
     * @return Default_Model_Mapper_ClassRestMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
                $this->setMapper(new Default_Model_Mapper_ClassRestMapper());
        }
        return $this->_mapper;
    }
    /**
     * Set class title
     * 
     * @param  string $title
     * @return Default_Model_Class
     */
    public function setTitle ($title)
    {
        $this->_title = (string) $title;
        return $this;
    }
    /**
     * Get class title
     * 
     * @return null|string
     */
    public function getTitle ()
    {
        return $this->_title;
    }
    /**
     * Set class class_id
     * 
     * @param  int $class_id 
     * @return Default_Model_Class
     */
    public function setClass_id ($class_id)
    {
        $this->_class_id = $class_id;
        return $this;
    }
    /**
     * Retrieve class class_id
     * 
     * @return null|int
     */
    public function getClass_id ()
    {
        return $this->_class_id;
    }
	/**
     * @return string
     */
    public function getMail ()
    {
        return $this->_mail;
    }

	/**
     * @param string $_mail
     * @return Default_Model_Class
     */
    public function setMail ($_mail)
    {
        $this->_mail = $_mail;
        return $this;
    }
	/**
     * @return null|string
     */
    public function getClassType ()
    {
        return $this->_classType;
    }

	/**
     * @param string $_classType
     * @return Default_Model_Class
     */
    public function setClassType ($_classType)
    {
        $this->_classType = $_classType;
        return $this;
    }
    /**
     * Fetch all classes
     * 
     * @return array
     */
    public function fetchAll (array $filterParams = array())
    {
        return $this->getMapper()->fetchAll($filterParams);
    }
    /**
     * Find an class
     * 
     * @param  int $class_id 
     * @return Default_Model_Class
     */
    public function find ($class_id)
    {
        $this->getMapper()->find($class_id, $this);
        return $this;
    }
	/**
     * @return array Default_Model_Class
     */
    public function getSubClasses ()
    {
        return $this->_subClasses;
    }

	/**
     * @param array $_subClasses
     * @return Default_Model_Class
     */
    public function setSubClasses ($_subClasses)
    {
        $this->_subClasses = $_subClasses;
        return $this;
    }
	/**
     * @return Default_Model_Class
     */
    public function getParent ()
    {
        return $this->_parent;
    }

	/**
     * @param Default_Model_Class $_parent
     */
    public function setParent ($_parent)
    {
        $this->_parent = $_parent;
        return $this; 
    }


}
