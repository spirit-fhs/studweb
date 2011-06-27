<?php
/**
 * DateFormat helper
 * 
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage viewHelper
 * @uses viewHelper Zend_View_Helper
 *  
 */
class Zend_View_Helper_DateFormat
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
	/**
	 * @param timestamp $time
	 */
    public function DateFormat ($time)
    {
        return date("d.m.Y H:i",strtotime($time));
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
