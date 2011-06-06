<?php
/**
 * This controller is responsible for the timetable or the event planning.
 * 
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage Controllers
 */
class TimetableController extends Zend_Controller_Action
{
    public function init(){
        // Load timetable navigaton depending on
        // the today's date and the semester start/end dates
        $xmlTag = $this->_helper->ActualSemester();
        $subconfig = new Zend_Config_Xml(
            APPLICATION_PATH . '/configs/timetables.xml', $xmlTag);
        // setPages -> replaces the subpages if they exists
        // addPages -> adds only the sides this results in this scenario in dublication
        $nav = $this->view->navigation(Zend_Registry::get('mainMenu'))->findOneBy('label','Stundenplan')->setPages($subconfig->toArray());
    }
    
    /**
     * this action will show the calendar/ timetable
     */
    public function indexAction ()
    {
        $course = $this->_getParam('course');
        if ($course != NULL) {
            $this->view->course = $course;
        }else{
            $this->view->message ='Please choose a course!';
        }
    }
    /**
     * With this procedure we can use url's like this: "spirit/timetable/bawi2"
     * But this way every class has to be an action.
     * Here helps us the __call function, which is called if no action were found.
     * 
     * @see Zend_Controller_Action::__call()
     */
    public function __call($method, $args)
    {
        if ('Action' == substr($method, -6)) {
            // If the action method was not found, forward to the
            // index action with the class as param
            $course = substr($method, 0,-6);
            return $this->_forward('index',null,null,array('course'=>$course));
        }
 
        // all other methods throw an exception
        throw new Exception('Invalid method "' . $method . '" called',500);
    }
}
