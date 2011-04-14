<?php
/**
 * Zend Bootstrap
 * @author	   Florian Schuhmann
 * @package    Default
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Autoloader
     * 
     */
    protected function _initAutoload()
    {
            $autoloader = Zend_Loader_Autoloader::getInstance();
            $autoloader->registerNamespace(array('Application_'));
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
    }
    /**
     * Bootstrap the layout navigation
     * 
     * @return void
     */
    protected function _initNavigation ()
    {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        
        $config = new Zend_Config_Xml(
        APPLICATION_PATH . '/configs/navigation.xml', 'nav');
        $container = new Zend_Navigation($config);
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
    /**
     * Bootstrap the Database and save it to the Registry
     * for later use.
     * 
     * @return void
     */
    protected function _initDatabase ()
    {
        if ('development' == APPLICATION_ENV) {
            $resource = $this->getPluginResource('db');
            $db = $resource->getDbAdapter();
            Zend_Registry::set("db", $db);
        }
    }
}

