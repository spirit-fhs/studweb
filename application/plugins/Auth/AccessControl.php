<?php
/**
 * This is the access control plugin, which checks the user rights after dispatching
 * 
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage Plugin
 *
 */
class Application_Plugin_Auth_AccessControl extends Zend_Controller_Plugin_Abstract
{
    /**
     * @param Zend_Auth $auth
     * @param Zend_Acl $acl
     * @return void 
     */
    public function __construct (Zend_Auth $auth, Zend_Acl $acl)
    {
        $this->_auth = $auth;
        $this->_acl = $acl;
    }
    /**
     * Checks the user rights
     * 
     * @param Zend_Controller_Request_Abstract $request
     * @see Zend_Controller_Plugin_Abstract::preDispatch()
     * @return void
     */
    public function preDispatch (Zend_Controller_Request_Abstract $request)
    {
        // get the names from the request 
        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        
        // checks if the user is logged in
    	if ($this->_auth->hasIdentity() && is_object(
        $this->_auth->getIdentity())) {
            // students can only log in
            $role = Application_Plugin_Auth_Roles::STUDENT;
        } else {
            $role = Application_Plugin_Auth_Roles::GUEST;
        }
        
        /*
         * get the view to set the acl role 
         * for the navigation
         */
        $viewRenderer = Zend_Controller_Action_HelperBroker::getExistingHelper('ViewRenderer');
        $viewRenderer->initView();
        $view = $viewRenderer->view;
        $view->navigation()->setRole($role);
        
        // resources = controller
        // privilege = action
        $resource = $controller;
        $privilege = $action;
        if (! $this->_acl->has($resource)) {
            $resource = null;
        }
        //	Debug $role, $resource, $privilege, 
        //echo var_dump($this->_auth->getIdentity());
         
         
        // checks if the role has the needed rights for the requested resource 
        if (! $this->_acl->isAllowed($role, $resource, $privilege)) {
            if ($this->_auth->hasIdentity()) {
                // logged in, but no rights 
                $request->setModuleName('default');
                $request->setControllerName('error');
                $request->setActionName('noAccess');
            } else {
                // not logged in
                $request->setModuleName('default');
                $request->setControllerName('login');
                $request->setActionName('login');
            }
        }
    }
}