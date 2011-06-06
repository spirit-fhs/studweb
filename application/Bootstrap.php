<?php
/**
 * Bootstrap
 * @author	   Florian Schuhmann
 * @package    Default
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * @var Zend_Acl
     */
    private $_acl = null;
    /**
     * @var Zend_Auth
     */
    private $_auth = null;
    /**
     * init Autoloader
     * @return void
     */
    protected function _initAutoload()
    {
            $autoloader = Zend_Loader_Autoloader::getInstance();
            $autoloader->registerNamespace(array('Application_'));
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
        Zend_Registry::set("mainMenu", $container);

        $config = new Zend_Config_Xml(
        APPLICATION_PATH . '/configs/navigation.xml', 'sidebar');
        $container = new Zend_Navigation($config);
        Zend_Registry::set("Sidebar", $container);
        //$view->getHelper('navigation')->navigation($container);

    }
    /**
     * Bootstrap the Auth + Acl
     * 
     * @return void
     */
    protected function _initAuth ()
    {
        $this->bootstrap('frontController');
        $this->_auth = Zend_Auth::getInstance();
        $this->_acl = new Application_Plugin_Auth_Acl();
        $this->getResource('frontController')
            ->registerPlugin(
        new Application_Plugin_Auth_AccessControl($this->_auth, $this->_acl))
            ->setParam('auth', $this->_auth);
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
    /**
     * We need to initialize the request to get
     * a valid baseUrl from the baseUrl view helper
     * in the _initView.
     * @return void
     */
    protected function _initBaseUrl() {
        $this->bootstrap("frontController");
        $front=$this->getResource("frontController");
        $request=new Zend_Controller_Request_Http();
        $front->setRequest($request);
    }     
    /**
     * Bootstrap the View with all header data
     * @return void
     */
    protected function _initView() {
        $layout = $this->getResource('layout');
        $view = $layout->getView();

        $view->doctype('HTML5');

        $view->headLink()->appendStylesheet($view->baseUrl().'/css/global.css');
        
        $view->headScript()->appendFile($view->baseUrl().'/js/label_over.js');
        $view->headScript()->appendScript('$(document).ready(function() {$(".overlabel").labelOver("over-apply")});');
        //to learn the IE HTML5 elements
        $view->headScript()->appendFile($view->baseUrl().'/js/html5.js','text/javascript',array('conditional' => 'lt IE 9'));
        
        $view->headMeta()->appendHttpEquiv('Content-Type','text/html;charset=utf-8');
        
        $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
        $view->jQuery()->enable();
        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $viewRenderer->setView($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
            
    }

}

