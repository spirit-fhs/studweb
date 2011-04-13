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
     * Autoloader
     * 
     */
    protected function _initAutoload()
    {
            $moduleLoader = new Zend_Application_Module_Autoloader(array(
                    'namespace' => '',
                    'basePath' => APPLICATION_PATH));

            $autoloader = Zend_Loader_Autoloader::getInstance();
            $autoloader->registerNamespace(array('Application_'));
            Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH . '/modules/default/controllers/helpers');
            return $moduleLoader;           
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

        /*
         * Load timetable navigaton depending on
         * the todays date and the semester start/end dates
         **/
        /*
        $today = mktime(0,0,0,2,1,2011);//strtotime('today');
        if(mktime(0,0,0, 3, 1, date('Y')) <= $today && 
        $today < mktime(0,0,0, 9, 1, date('Y')))
            $xmlTag = 'SS';
        else
            $xmlTag = 'WS';

        $subconfig = new Zend_Config_Xml(
        APPLICATION_PATH . '/configs/timetables.xml', $xmlTag);
        $container->findOneBy('label','Stundenplan')->addPages($subconfig);
        */
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

