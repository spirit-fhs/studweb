<?php
/**
 * Event model
 *
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage Model
 */
class Default_Model_Event
{
    /**
     * @var int
     */
    protected $_event_id;
    /**
     * @var string
     */
    protected $_titleShort;
    /**
     * @var string
     */
    protected $_titleLong;
    /**
     * @var array Default_Model_Class
     */
    protected $_degreeClass;
    /**
     * @var array Default_Model_Owner
     */
    protected $_lecturer;
    /**
     * @var string
     */
    protected $_eventType;
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
     * Set event_id
     * 
     * @param  int $event_id 
     * @return Default_Model_Event
     */
    public function setEvent_id ($event_id)
    {
        $this->_event_id = $event_id;
        return $this;
    }
    /**
     * Retrieve event_id
     * 
     * @return null|int
     */
    public function getEvent_id ()
    {
        return $this->_event_id;
    }
	/**
     * @return string
     */
    public function getTitleShort ()
    {
        return $this->_titleShort;
    }

	/**
     * @return string
     */
    public function getTitleLong ()
    {
        return $this->_titleLong;
    }

	/**
     * @return array Default_Model_Class
     */
    public function getDegreeClass ()
    {
        return $this->_degreeClass;
    }

	/**
     * @return array Default_Model_Owner
     */
    public function getLecturer ()
    {
        return $this->_lecturer;
    }
    
	/**
     * @return string
     */
    public function getEventType ()
    {
        return $this->_eventType;
    }
    
	/**
     * @param string $_titleShort
     * @return Default_Model_Event
     */
    public function setTitleShort ($_titleShort)
    {
        $this->_titleShort = $_titleShort;
        return $this;
    }

	/**
     * @param string $_titleLong
     * @return Default_Model_Event
     */
    public function setTitleLong ($_titleLong)
    {
        $this->_titleLong = $_titleLong;
        return $this;
    }

	/**
     * @param array $_degreeClass
     * @return Default_Model_Event
     */
    public function setDegreeClass ($_degreeClass)
    {
        $this->_degreeClass = $_degreeClass;
        return $this;
    }

	/**
     * @param array $_lecturer
     * @return Default_Model_Event
     */
    public function setLecturer ($_lecturer)
    {
        $this->_lecturer = $_lecturer;
        return $this;
    }

	/**
     * @param string $_eventType
     * @return Default_Model_Event
     */
    public function setEventType ($_eventType)
    {
        $this->_eventType = $_eventType;
        return $this;
    }


}
