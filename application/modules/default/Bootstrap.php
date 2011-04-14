<?php
class Default_Bootstrap extends Zend_Application_Module_Bootstrap
{
    protected function _initActionHelpers() {
        Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH . '/modules/default/controllers/helpers');
    }
}
