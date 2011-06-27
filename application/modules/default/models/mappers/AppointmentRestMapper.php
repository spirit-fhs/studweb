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
     * constant definition for the event colors 
     * 
     */
    const MOVED_TEXT_COLOR = '#222222';
    const MOVED_BACKGROUND_COLOR = '#f8da4e';
    const MOVED_BORDER_COLOR = '#fcd113';
    
    const CANCELLED_TEXT_COLOR = '#222222';
    const CANCELLED_BACKGROUND_COLOR = '#CCCCCC';
    const CANCELLED_BORDER_COLOR = '#AAAAAA';
    
    const PRACTICE_TEXT_COLOR = '#ffffff';
    const PRACTICE_BACKGROUND_COLOR = '#327e04';
    const PRACTICE_BORDER_COLOR = '#459e00';
    
    const LECTURE_TEXT_COLOR = '#ffffff';
    const LECTURE_BACKGROUND_COLOR = '#3366CC';
    const LECTURE_BORDER_COLOR = '#3366CC';

    const BLOCK_PRACTICE_TEXT_COLOR = '#ffffff';
    const BLOCK_PRACTICE_BACKGROUND_COLOR = '#f58400';
    const BLOCK_PRACTICE_BORDER_COLOR = '#ffaf0f';
    
    const BLOCK_LECTURE_TEXT_COLOR = '#111111';
    const BLOCK_LECTURE_BACKGROUND_COLOR = '#ffc73d';
    const BLOCK_LECTURE_BORDER_COLOR = '#ffb73d';

    const DEFAULT_TEXT_COLOR = 'yellow';
    const DEFAULT_BACKGROUND_COLOR = '#000000';
    const DEFAULT_BORDER_COLOR = '#000000';    

    /**
     * @var Default_Service_Spirit
     */
    protected $_service;
    /**
     * Specify Default_Service_Spirit instance to use for data operations
     * 
     * @param  Default_Service_Spirit $service 
     * @return Default_Model_Mapper_AppointmentRestMapper
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
     * @return array Default_Model_Appointment
     */
    public function fetchAll (array $params = array())
    {
        $params['responseType'] = 'json';
        $response = $this->getService()->fetchAllAppointments($params);

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

            //convert appointment locations to Default_Model_Location
            $locations = array();
            foreach ($row->location as $location){
                $l = new Default_Model_Location();
                $l->setBuilding($location->building)
                    ->setRoom($location->room);
                $locations[] = $l;
            }

        	//put all in the $appointment
            $appointment = new Default_Model_Appointment();
            $appointment->setAppointment_id($row->appointment_id)
                ->setStartAppointment($row->startAppointment)
                ->setEndAppointment($row->endAppointment)
                ->setStatus($row->status)
                ->setEvent($event)
                ->setLocation($locations)
                ->setMapper($this);
            if(isset($row->childAppointment->appointment_id))
                $appointment->setChildAppointment($row->childAppointment->appointment_id);
                
            $appointments[] = $appointment;
            
        }
        return $appointments;
    }
    /**
     * find one appointments
     * 
     * @param  int $id 
     * @param  Default_Model_Appointment $appointment 
     * @uses   Default_Service_Spirit
     * @return void
     */
    public function find ($id, Default_Model_Appointment $appointment)
    {
        $params = array('responseType' => 'json');
        $response = $this->getService()->findAppointment($id, $params);

        if(isset($response->error))
            return;
        
        $row = $response->appointment;
            
            //convert event lecturer to Default_Model_Owner
            $lectureres = array();
            foreach ($row[0]->event->lecturer as $lecturer){
                $l = new Default_Model_Owner();
                $l->setFhs_id($lecturer->fhs_id)
                    ->setDisplayedName($lecturer->displayedName)
                    ->setMemberType($lecturer->memberType);
                $lectureres[] = $l;
            }
            
            //convert event degreeClass to Default_Model_Class
            $classes = array();
            foreach ($row[0]->event->degreeClass as $class){
                $c = new Default_Model_Class();
                $c->setClass_id($class->class_id)
                    ->setTitle($class->title)
                    ->setMail($class->mail)
                    ->setClassType($class->classType);
                $classes[] = $c;
            }

            
            //convert event to Default_Model_Event
            $event = new Default_Model_Event();
            $event->setEvent_id($row[0]->event->event_id)
                ->setTitleShort($row[0]->event->titleShort)
                ->setTitleLong($row[0]->event->titleLong)
                ->setLecturer($lectureres)
                ->setDegreeClass($classes)
                ->setEventType($row[0]->event->eventType);

            //convert appointment locations to Default_Model_Location
            $locations = array();
            foreach ($row[0]->location as $location){
                $l = new Default_Model_Location();
                $l->setBuilding($location->building)
                    ->setRoom($location->room);
                $locations[] = $l;
            }

        	//put all in the $appointment
            $appointment->setAppointment_id($row[0]->appointment_id)
                ->setStartAppointment($row[0]->startAppointment)
                ->setEndAppointment($row[0]->endAppointment)
                ->setStatus($row[0]->status)
                ->setEvent($event)
                ->setLocation($locations)
                ->setMapper($this);
            if(isset($row[0]->childAppointment->appointment_id))
                $appointment->setChildAppointment($row[0]->childAppointment->appointment_id);
                
            
    }
    /**
     * Returns an array for the jQuery fullcalendar
     * 
     * @param array $params
     * @return array
     */
    public function fetchAllAsCalendarJson(array $params = array())
    {
        $appointments = array();
        if(! $appointments = $this->fetchAll())// TODO $params
            return;

        $CalendarJson = array();
        foreach ($appointments as $appointment){
            $CalendarEvent = array();
            $CalendarEvent['appointment_id'] = $appointment->getAppointment_id();
            $CalendarEvent['start'] = $appointment->getStartAppointment();
            $CalendarEvent['end'] = $appointment->getEndAppointment();

            $CalendarEvent['startTime'] = date('H:i',strtotime($appointment->getStartAppointment()));
            $CalendarEvent['endTime'] = date('H:i',strtotime($appointment->getEndAppointment()));
            
            $CalendarEvent['status'] = $appointment->getStatus();
            
            $event = $appointment->getEvent();
            $CalendarEvent['title'] = $event->getTitleShort();
            $CalendarEvent['titleLong'] = $event->getTitleLong();
            $CalendarEvent['event_id'] = $event->getEvent_id();
            $CalendarEvent['eventType'] = $event->getEventType();

            switch($appointment->getStatus()){
                case 'moved':
                    $CalendarEvent['textColor'] = self::MOVED_TEXT_COLOR;            
                    $CalendarEvent['backgroundColor'] = self::MOVED_BACKGROUND_COLOR;
                    $CalendarEvent['borderColor'] = self::MOVED_BORDER_COLOR;
                    break;
                case 'cancelled':
                    $CalendarEvent['textColor'] = self::CANCELLED_TEXT_COLOR;            
                    $CalendarEvent['backgroundColor'] = self::CANCELLED_BACKGROUND_COLOR;
                    $CalendarEvent['borderColor'] = self::CANCELLED_BORDER_COLOR;
                    break;                    
                case 'ok':
                default:
                        switch ($event->getEventType()) {
                            case 'Practice':
                                $CalendarEvent['textColor'] = self::PRACTICE_TEXT_COLOR;            
                                $CalendarEvent['backgroundColor'] = self::PRACTICE_BACKGROUND_COLOR;
                                $CalendarEvent['borderColor'] = self::PRACTICE_BORDER_COLOR;
                                break;
                            case 'Lecture':
                                $CalendarEvent['textColor'] = self::LECTURE_TEXT_COLOR;            
                                $CalendarEvent['backgroundColor'] = self::LECTURE_BACKGROUND_COLOR;
                                $CalendarEvent['borderColor'] = self::LECTURE_BORDER_COLOR;
                                break;
                            case 'BlockPractice':
                                $CalendarEvent['textColor'] = self::BLOCK_PRACTICE_TEXT_COLOR;
                                $CalendarEvent['backgroundColor'] = self::BLOCK_PRACTICE_BACKGROUND_COLOR;
                                $CalendarEvent['borderColor'] = self::BLOCK_PRACTICE_BORDER_COLOR;
                                break;
                            case 'BlockLecture':
                                $CalendarEvent['textColor'] = self::BLOCK_LECTURE_TEXT_COLOR;
                                $CalendarEvent['backgroundColor'] = self::BLOCK_LECTURE_BACKGROUND_COLOR;
                                $CalendarEvent['borderColor'] = self::BLOCK_LECTURE_BORDER_COLOR;
                                break;
                            default:
                                $CalendarEvent['textColor'] = self::DEFAULT_TEXT_COLOR;
                                $CalendarEvent['backgroundColor'] = self::DEFAULT_BACKGROUND_COLOR;
                                $CalendarEvent['borderColor'] = self::DEFAULT_BORDER_COLOR;
                                break;
            }            }

            
            $owners = $event->getLecturer();
            foreach ($owners as $owner){
                $CalendarEvent['owners'][$owner->getFhs_id()] = $owner->getDisplayedName();
            }
            $locations = $appointment->getLocation();
            foreach ($locations as $location){
                $CalendarEvent['locations'][] = $location->getBuilding() . ' ' . $location->getRoom();
            }
            
            if ($appointment->getChildAppointment()) {
                $a = new Default_Model_Appointment();
                $child = $a->find($appointment->getChildAppointment());
                // TODO add child logic
                $CalendarEvent['child'] = $appointment->getChildAppointment();
            }
            
            $CalendarEvent['allDay'] = false;
            
            $CalendarJson[] = $CalendarEvent;
        }
        return $CalendarJson;
    }
}
?>