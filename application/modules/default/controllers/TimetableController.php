<?php
/**
 * TimetableController
 * 
 * @author Florian Schuhmann
 * @version 
 */
class TimetableController extends Zend_Controller_Action
{
    public function init(){
        /*
         * Load timetable navigaton depending on
         * the todays date and the semester start/end dates
         **/
        $xmlTag = $this->_helper->ActualSemester();
        $subconfig = new Zend_Config_Xml(
        APPLICATION_PATH . '/configs/timetables.xml', $xmlTag);
        // setPages -> replaces the subpages if they exists
        $nav = $this->view->navigation(Zend_Registry::get('mainMenu'))->findOneBy('label','Stundenplan')->setPages($subconfig->toArray());
    }
    
    /**
     * The default action - show the timetable
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
    
    public function __call($method, $args)
    {
        if ('Action' == substr($method, -6)) {
            // If the action method was not found, forward to the
            // index action
            $course = substr($method, 0,-6);
            return $this->_forward('index',null,null,array('course'=>$course));
        }
 
        // all other methods throw an exception
        throw new Exception('Invalid method "' . $method . '" called',500);
    }
}
