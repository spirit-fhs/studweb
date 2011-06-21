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
        if (! method_exists($this, $method)) {
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
        if (! method_exists($this, $method)) {
            throw Exception('Invalid property specified');
        }
        return $this->$method();
    }
    /**
     * Set object state
     * 
     * @param  array $options 
     * @return Default_Model_Entry
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


}
