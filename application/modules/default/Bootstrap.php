<?php
/**
 * Default Bootstrap
 * @author	   Florian Schuhmann
 * @package    Default
 */
class Default_Bootstrap extends Zend_Application_Module_Bootstrap
{
    /**
     * init the action helpers for this modul 
     */
    protected function _initActionHelpers() {
        Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH . '/modules/default/controllers/helpers');
    }
}
