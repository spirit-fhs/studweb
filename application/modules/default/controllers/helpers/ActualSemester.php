<?php
/**
 * This ist the ActualSemester Action Helper.
 * It differs according to the current date between summer and winter semester.
 * 
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage actionHelper
 * @uses actionHelper Zend_Controller_Action_Helper
 */
class Zend_Controller_Action_Helper_ActualSemester extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * @var Zend_Loader_PluginLoader
     */
    public $pluginLoader;
    /**
     * Constructor: initialize plugin loader
     * 
     * @return void
     */
    public function __construct ()
    {
        $this->pluginLoader = new Zend_Loader_PluginLoader();
    }
    /**
     * Return a shortcut according to the current date.
     * 
     * @return string
     */
    public function direct ()
    {
        // get the date of today
        $today = strtotime('today');
        // check if today is between TODAYS_YEAR-3-1 and TODAYS_YEAR-10-1
        if(mktime(0,0,0, 3, 1, date('Y')) <= $today && 
        $today < mktime(0,0,0, 10, 1, date('Y')))
           return 'SS';
        else
           return 'WS';
    }
}
