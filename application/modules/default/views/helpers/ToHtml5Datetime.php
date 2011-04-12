<?php
/**
 *
 * @author Florian Schuhmann
 * @version 
 */
/**
 * toHtml5Datetime helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_ToHtml5Datetime
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    public function toHtml5Datetime ($time)
    {
	    $time = explode('.',$time); 
        return date("Y-m-d",mktime(0, 0, 0, $time[1], $time[0], $time[2]));
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
