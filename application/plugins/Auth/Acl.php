<?php
class Application_Plugin_Auth_Acl extends Zend_Acl
{
    public function __construct ()
    {
        // RESSOURCES
        /**
         * role = student
         * resource  = controller
         * privilege = action 
         */
        $this->addRole(new Zend_Acl_Role(Application_Plugin_Auth_Roles::GUEST));
        $this->addRole(new Zend_Acl_Role(Application_Plugin_Auth_Roles::STUDENT), Application_Plugin_Auth_Roles::GUEST);
        $this->add(new Zend_Acl_Resource('index'));
        $this->add(new Zend_Acl_Resource('login'));
        $this->add(new Zend_Acl_Resource('entry'));
        $this->add(new Zend_Acl_Resource('error'));
        $this->add(new Zend_Acl_Resource('timetable'));
        $this->add(new Zend_Acl_Resource('html5'));
        // guest 
        $this->allow(Application_Plugin_Auth_Roles::GUEST, null, 'index');
        $this->allow(Application_Plugin_Auth_Roles::GUEST, 'entry', 'show');
        $this->allow(Application_Plugin_Auth_Roles::GUEST, 'error');
        $this->allow(Application_Plugin_Auth_Roles::GUEST, 'timetable');
        $this->allow(Application_Plugin_Auth_Roles::GUEST, 'login', 'login');
        $this->allow(Application_Plugin_Auth_Roles::GUEST, 'html5');
        // students
        $this->allow(Application_Plugin_Auth_Roles::STUDENT, 'login');
        $this->deny(Application_Plugin_Auth_Roles::STUDENT, 'login', 'login');
        $this->allow(Application_Plugin_Auth_Roles::STUDENT, 'entry');
        
    
        Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($this);
        Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole(Application_Plugin_Auth_Roles::GUEST);
    }
}