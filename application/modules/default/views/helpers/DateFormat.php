<?php
/**
 *
 * @author Florian Schuhmann
 * @version 
 */
/**
 * DateFormat helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_DateFormat
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    public function DateFormat ($time)
    {
        return date("d.m.Y H:s",strtotime($time));
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
