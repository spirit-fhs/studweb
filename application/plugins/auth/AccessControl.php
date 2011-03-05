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
        if ($this->_auth->hasIdentity() && is_object(
        $this->_auth->getIdentity())) {
            $role = $this->_auth->getIdentity()->role;
        } else {
            $role = 'guest';
        }
        $module = $request->getModuleName();
        // Ressourcen = Modul -> kann hier geändert werden!
        $resource = $module;
        if (! $this->_acl->has($resource)) {
            $resource = null;
        }
        //TODO change the following redirects
        if (! $this->_acl->isAllowed($role, $resource)) {
            if ($this->_auth->hasIdentity()) {
                // angemeldet, aber keine Rechte -> Fehler!
                $request->setModuleName('default');
                $request->setControllerName('error');
                $request->setActionName('noAccess');
            } else {
                //nicht angemeldet -> Login
                $request->setModuleName('default');
                $request->setControllerName('login');
                $request->setActionName('login');
            }
        }
    }
}