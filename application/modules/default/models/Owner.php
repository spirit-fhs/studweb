<?php
/**
 * Owner model
 *
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage Model
 */
class Default_Model_Owner
{
    /**
     * @var int
     */
    protected $_fhs_id;
    /**
     * @var string
     */
    protected $_displayedName;
    /**
     * @var string
     */
    protected $_memberType;
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
     * @return Default_Model_Owner
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
     * Retrieve fhs_id
     * 
     * @return null|int
     */
    public function getFhs_id ()
    {
        return $this->_fhs_id;
    }
    /**
     * @return null|string
     */
    public function getDisplayedName ()
    {
        return $this->_displayedName;
    }
	/**
     * @return null|string
     */
    public function getMemberType ()
    {
        return $this->_memberType;
    }
    /**
     * Set fhs_id
     * 
     * @param  string $fhs_id 
     * @return Default_Model_Owner
     */
    public function setFhs_id ($fhs_id)
    {
        $this->_fhs_id = $fhs_id;
        return $this;
    }
    /**
     * @param string $_displayedName
     * @return Default_Model_Owner
     */
    public function setDisplayedName ($_displayedName)
    {
        $this->_displayedName = $_displayedName;
        return $this;
    }
	/**
     * @param string $_memberType
     * @return Default_Model_Owner
     */
    public function setMemberType ($_memberType)
    {
        $this->_memberType = $_memberType;
        return $this;
    }

}
