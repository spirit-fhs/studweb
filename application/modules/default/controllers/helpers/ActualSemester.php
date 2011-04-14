<?php
/**
 *
 * @author Florian Schuhmann
 * @version 
 */
/**
 * ActualSemester Action Helper 
 * 
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
     * Strategy pattern: call helper as broker method
     */
    public function direct ()
    {
        $today = strtotime('today');
        if(mktime(0,0,0, 3, 1, date('Y')) <= $today && 
        $today < mktime(0,0,0, 9, 1, date('Y')))
           return 'SS';
        else
           return 'WS';
    }
}
