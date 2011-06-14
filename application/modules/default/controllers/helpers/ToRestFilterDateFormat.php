<?php
/**
 * This is the ToRestFilterDateFormat Action Helper.
 * It returns the needed format to send the filter to REST.
 * 
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage actionHelper
 * @uses actionHelper Zend_Controller_Action_Helper
 */
class Zend_Controller_Action_Helper_ToRestFilterDateFormat extends Zend_Controller_Action_Helper_Abstract
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
     * Return a formated date.
     * @param string $date
     * @return string
     */
    public function direct ($date)
    {
        // get the date
        return date('YmdHis',$date);
    }
}
