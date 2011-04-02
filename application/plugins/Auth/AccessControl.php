<?php
class Application_Plugin_Auth_AccessControl extends Zend_Controller_Plugin_Abstract
{
    public function __construct (Zend_Auth $auth, Zend_Acl $acl)
    {
        $this->_auth = $auth;
        $this->_acl = $acl;
    }
    public function preDispatch (Zend_Controller_Request_Abstract $request)
    {

        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        
    	if ($this->_auth->hasIdentity() && is_object(
        $this->_auth->getIdentity())) {
            // students can only log in
            $role = Application_Plugin_Auth_Roles::STUDENT;
        } else {
            $role = Application_Plugin_Auth_Roles::GUEST;
        }

        // resources = controller
        // privilege = action
        $resource = $controller;
        $privilege = $action;
        if (! $this->_acl->has($resource)) {
            $resource = null;
        }
        //	Debug $role, $resource, $privilege, 
        //echo var_dump($this->_auth->getIdentity());
         
         
        
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