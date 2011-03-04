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

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		$entry = new Default_Model_Entry();
        $this->view->entries = $entry->fetchAll();
    }

}

