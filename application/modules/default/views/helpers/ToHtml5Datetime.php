<?php
/**
 * toHtml5Datetime helper
 *
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage viewHelper
 * @uses viewHelper Zend_View_Helper
 *  
 */
class Zend_View_Helper_ToHtml5Datetime
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * @param timestamp $time
     */
    public function toHtml5Datetime ($time)
    {
	    //$time = explode('.',$time); 
        return date("Y-m-d",strtotime($time));
    }
    /**
     * Sets the view field 
     * @param $view Zend_View_Interface
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }
}
