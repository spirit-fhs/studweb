<?php
/**
 * Default ErrorController
 *
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage Controllers
 */
class ErrorController extends Zend_Controller_Action
{
    /**
     * 
     * This action is called when an error occurs somewhere.
     */
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        if (!$errors) {
            $this->view->message = 'You have reached the error page';
            return;
        }
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }
        
        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->crit($this->view->message, $errors->exception);
        }
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        
        $this->view->request   = $errors->request;
    }
    /**
     * 
     * gets the log from the bootstrap if it is available
     */
    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }
    /**
     * 
     * This action ist called if the user have no access.
     */
    public function noaccessAction(){
    	$this->view->message = "You have no access!";
    }
    /**
     * 
     * This action is called if no news were found.
     */
    public function notfoundAction(){
    	$this->view->message = "Sorry no News found!";
    }


}

