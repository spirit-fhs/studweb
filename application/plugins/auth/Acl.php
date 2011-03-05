<?php
class Application_Plugin_Auth_Acl extends Zend_Acl
{
  public function __construct()
  { 
   // RESSOURCES
   // TODO Change this
   $this->add(new Zend_Acl_Resource('admin'));
   $this->add(new Zend_Acl_Resource('redaktion'));
   $this->addRole(new Zend_Acl_Role('guest'));
   $this->addRole(new Zend_Acl_Role('redakteur'), 'guest');
   $this->addRole(new Zend_Acl_Role('admin'), 'redakteur');
   $this->allow(null, null);
   $this->deny('guest', 'redaktion');
   $this->deny('guest', 'admin');
   $this->allow('redakteur','redaktion');
   $this->allow('admin', 'admin');
  }
}
