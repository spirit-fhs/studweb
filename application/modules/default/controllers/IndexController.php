<?php
/**
 * Default IndexController
 * 
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage Controllers
 */
class IndexController extends Zend_Controller_Action
{
    public function init ()
    {
    }
    /**
     * 
     * this action only forwards to the indexAction of the EntryController
     */
    public function indexAction ()
    {
        $this->_forward('index', 'entry');
    }
}