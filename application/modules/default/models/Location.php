<?php
/**
 * Location model
 *
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage Model
 */
class Default_Model_Location
{
    /**
     * @var string
     */
    protected $_building;
    /**
     * @var string
     */
    protected $_room;
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
     * @return Default_Model_Location
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
     * @return null|string
     */
    public function getBuilding ()
    {
        return $this->_building;
    }

	/**
     * @return null|string
     */
    public function getRoom ()
    {
        return $this->_room;
    }

	/**
     * @param string $_building
     * @return Default_Model_Location
     */
    public function setBuilding ($_building)
    {
        $this->_building = $_building;
        return $this;
    }

	/**
     * @param string $_room
     * @return Default_Model_Location
     */
    public function setRoom ($_room)
    {
        $this->_room = $_room;
        return $this;
    }

}
