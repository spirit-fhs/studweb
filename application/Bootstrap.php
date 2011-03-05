<?php
/**
 * Zend Bootstrap
 * @author	   Florian Schuhmann
 * @package    Default
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Bootstrap the modular file structure 
     * 
     * @return void
     */
    protected function _initSiteModules ()
    {
        //Don't forget to bootstrap the front controller as the resource may not been created yet...  
        $this->bootstrap("frontController");
        $front = $this->getResource("frontController");
        //Add modules dirs to the controllers for default routes...  
        $front->addModuleDirectory(APPLICATION_PATH . '/modules');
    }
    /**
     * Bootstrap the view headMeta
     * 
     * @return void
     */
    protected function _initMeta ()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->headMeta()->appendHttpEquiv('Content-Type', 
        'text/html;charset=utf-8');
    }
    /**
     * Bootstrap the view doctype
     * 
     * @return void
     */
    protected function _initDoctype ()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML5');
        $view->headMeta()->appendHttpEquiv('Content-Type', 
        'text/html;charset=utf-8');
    }
    /**
     * Bootstrap the layout navigation
     * 
     * @return void
     */
    protected function _initNavigation ()
    {
        $config = new Zend_Config_Xml(
        APPLICATION_PATH . '/configs/navigation.xml', 'nav');
        $container = new Zend_Navigation($config);
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $view->getHelper('navigation')->navigation($container);
    }
    /**
     * Bootstrap the Auth + Acl
     * 
     * @return void
     */
    protected function _initAuth ()
    {
        $this->bootstrap('frontController');
        $auth = Zend_Auth::getInstance();
        $acl = new Application_Plugin_Auth_Acl();
        $this->getResource('frontController')
            ->registerPlugin(
        new Application_Plugin_Auth_AccessControl($auth, $acl))
            ->setParam('auth', $auth);
    }
    /*
    protected function _initDb ()
    {
        $resource = $this->getPluginResource('db');
        $db = $resource->getDbAdapter();
        Zend_Registry::set("db", $db);
    }*/
}

