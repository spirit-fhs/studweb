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

        $xmlTag = $this->_helper->ActualSemester();
        $subconfig = new Zend_Config_Xml(
        APPLICATION_PATH . '/configs/timetables.xml', $xmlTag);
        $nav = $this->view->navigation()->findOneBy('label','Stundenplan')->addPages($subconfig);;
    }
    
    /**
     * The default action - show the home page
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
