<?php
/**
 * Appointment model
 *
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage Model
 */
class Default_Model_Appointment
{
    /**
     * @var int
     */
    protected $_appointment_id;
    /**
     * @var string
     */
    protected $_startAppointment;
    /**
     * @var string
     */
    protected $_endAppointment;
    /**
     * @var string
     */
    protected $_status;
    /**
     * @var Default_Model_Event
     */
    protected $_event;
    /**
     * @var int
     */
    protected $_childAppointment;
    /**
     * @var Default_Model_Mapper_AppointmentRestMapper
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
     * Lazy loads Default_Model_Mapper_AppointmentRestMapper instance if no mapper registered.
     * 
     * @return Default_Model_Mapper_AppointmentRestMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
                $this->setMapper(new Default_Model_Mapper_AppointmentRestMapper());
        }
        return $this->_mapper;
    }
    
    /**
     * Set appointment_id
     * 
     * @param  int $appointment_id 
     * @return Default_Model_Appointment
     */
    public function setAppointment_id ($appointment_id)
    {
        $this->_appointment_id = $appointment_id;
        return $this;
    }
    /**
     * Retrieve appointment_id
     * 
     * @return null|int
     */
    public function getAppointment_id ()
    {
        return $this->_appointment_id;
    }
	/**
     * @return string
     */
    public function getStartAppointment ()
    {
        return $this->_startAppointment;
    }

	/**
     * @return string
     */
    public function getEndAppointment ()
    {
        return $this->_endAppointment;
    }

	/**
     * @return string
     */
    public function getStatus ()
    {
        return $this->_status;
    }

	/**
     * @return Default_Model_Event
     */
    public function getEvent ()
    {
        return $this->_event;
    }
    
	/**
     * @return int
     */
    public function getChildAppointment ()
    {
        return $this->_childAppointment;
    }
    
	/**
     * @param string $_startAppointment
     * @return Default_Model_Appointment
     */
    public function setStartAppointment ($_startAppointment)
    {
        $this->_startAppointment = $_startAppointment;
        return $this;
    }

	/**
     * @param string $_endAppointment
     * @return Default_Model_Appointment
     */
    public function setEndAppointment ($_endAppointment)
    {
        $this->_endAppointment = $_endAppointment;
        return $this;
    }

	/**
     * @param string $_status
     * @return Default_Model_Appointment
     */
    public function setStatus ($_status)
    {
        $this->_status = $_status;
        return $this;    
    }

	/**
     * @param Default_Model_Event $_event
     * @return Default_Model_Appointment
     */
    public function setEvent ($_event)
    {
        $this->_event = $_event;
        return $this;
    }

	/**
     * @param int $_childAppointment
     * @return Default_Model_Appointment
     */
    public function setChildAppointment ($_childAppointment)
    {
        $this->_childAppointment = $_childAppointment;
        return $this;
    }
    
    /**
     * Fetch all appointments
     * 
     * @return array
     */
    public function fetchAll (array $filterParams = array())
    {
        return $this->getMapper()->fetchAllAsCalendarJson($filterParams);
    }
}