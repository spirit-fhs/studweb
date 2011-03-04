<?php

/**
 * Zend Bootstrap
 * @author	   Florian Schuhmann
 * @package    Default
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initSiteModules ()
    {
        //Don't forget to bootstrap the front controller as the resource may not been created yet...  
        $this->bootstrap("frontController");
        $front = $this->getResource("frontController");
        //Add modules dirs to the controllers for default routes...  
        $front->addModuleDirectory(APPLICATION_PATH . '/modules');
    }
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
     * Bootstrap autoloader for application resources
     * 
     * @return Zend_Application_Module_Autoloader
     */
    /*
    protected function _initAutoload ()
    {
        $autoloader = new Zend_Application_Module_Autoloader(
        array('namespace' => 'Default', 'basePath' => APPLICATION_PATH."/modules"));
        return $autoloader;
    }*/
    protected function _initNavigation ()
    {
 /*       $container = new Zend_Navigation(
        array(
        	array('label' => 'Home',
        		  'controller' => 'index',
        		  'action' => 'index',
        	      'pages' => array(
	        			array('label' => 'Seite 1.1', 
	        				  'controller' => 'index',
	        				  'action' => 'indexTow',
	        				  'class' => 'sub',
	        				  
	        			),
	        			array('label' => 'Seite 1.2',
	       					  'uri' => '/index/indexTow'
	        			), 
       					array('type' => 'uri',
     					      'label' => 'Seite 1.3',
   						      'uri' => 'page-1.3',
   							  'action' => 'about'
       					)
   					)
        		), 
	        array('label' => 'Seite 2',
	        	  'id' => 'page_2_and_3', 
	        	  'class' => 'my-class',
	              'module' => 'page2',
	        	  'controller' => 'index',
	        	  'action' => 'page1'
	        ), 
	        array('label' => 'Seite 3',
	        	  'id' => 'page_2_and_3',
	        	  'module' => 'page3',
	        	  'controller' => 'index'
	        )
        ));
        */
        $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
        $container = new Zend_Navigation($config);

        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
		$view = $layout->getView();
		$view->getHelper('navigation')->navigation($container);
		
        
        ;
    }
}

