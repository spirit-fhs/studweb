<?php
/**
 * Appointment data mapper
 *
 * Implements the Data Mapper design pattern:
 * http://www.martinfowler.com/eaaCatalog/dataMapper.html
 * 
 * @uses       Default_Service_Spirit
 * @package    Default
 * @subpackage Model
 */
class Default_Model_Mapper_AppointmentRestMapper
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
     * Fetch all appointments
     * 
     * @uses   Default_Service_Spirit
     * @return array
     */
    public function fetchAll (array $filterParams = array())
    {
        $params = array('type'=>'json');
        $response = $this->getService()->fetchAllAppointments($filterParams,$params);

        if(isset($response->error))
            return;
        $resultSet = $response->appointment;
        $appointments = array();

        foreach ($resultSet as $row) {
            
            //convert event lecturer to Default_Model_Owner
            $lectureres = array();
            foreach ($row->event->lecturer as $lecturer){
                $l = new Default_Model_Owner();
                $l->setFhs_id($lecturer->fhs_id)
                    ->setDisplayedName($lecturer->displayedName)
                    ->setMemberType($lecturer->memberType);
                $lectureres[] = $l;
            }
            
            //convert event degreeClass to Default_Model_Class
            $classes = array();
            foreach ($row->event->degreeClass as $class){
                $c = new Default_Model_Class();
                $c->setClass_id($class->class_id)
                    ->setTitle($class->title)
                    ->setMail($class->mail)
                    ->setClassType($class->classType);
                $classes[] = $c;
            }

            
            //convert event to Default_Model_Event
            $event = new Default_Model_Event();
            $event->setEvent_id($row->event->event_id)
                ->setTitleShort($row->event->titleShort)
                ->setTitleLong($row->event->titleLong)
                ->setLecturer($lectureres)
                ->setDegreeClass($classes)
                ->setEventType($row->event->eventType);


        	//put all in the $entry
            // TODO add Location
            $appointment = new Default_Model_Appointment();
            $appointment->setAppointment_id($row->appointment_id)
                ->setStartAppointment($row->startAppointment)
                ->setEndAppointment($row->endAppointment)
                ->setStatus($row->status)
                ->setEvent($event)
                ->setMapper($this);
            if(isset($row->childAppointment))
                $appointment->setChildAppointment($row->childAppointment->appointment_id);
                
            $appointments[] = $appointment;
            
        }
        return $appointments;
    }
    public function fetchAllAsCalendarJson(array $filterParams = array())
    {
        $appointments = array();
        if(! $appointments = $this->fetchAll($filterParams))
            return;

        $CalendarJson = array();
        foreach ($appointments as $appointment){
            $CalendarEvent = array();
            $CalendarEvent['start'] = $appointment->getStartAppointment();
            $CalendarEvent['end'] = $appointment->getEndAppointment();
            
            $event = $appointment->getEvent();
            $CalendarEvent['title'] = $event->getTitleShort();
            $CalendarEvent['titleLong'] = $event->getTitleLong();
            $CalendarEvent['event_id'] = $event->getEvent_id();
            
            $owners = $event->getLecturer();
            foreach ($owners as $owner){
                $CalendarEvent['owners'][$owner->getFhs_id()] = $owner->getDisplayedName();
            }
            $CalendarEvent['className'] = 'fhsSpirit-event-status-' . $appointment->getStatus();
            
            
            $CalendarEvent['allDay'] = false;
            
            $CalendarJson[] = $CalendarEvent;
        }
        return $CalendarJson;
    }
}
?>