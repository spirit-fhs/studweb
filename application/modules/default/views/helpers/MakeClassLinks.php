<?php
/**
 *
 * @author Florian Schuhmann
 * @version 
 */
/**
 * DateFormat helper
 *
 * @uses viewHelper Zend_View_Helper
 */

class Zend_View_Helper_MakeClassLinks
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    public function MakeClassLinks (array $classes = array())
    {
		/** TODO change this when classes are defined */
        $links = '';
        foreach ($classes as $class){
            $links .= '<a href="' . 
                $this->url(array(
            		'controller' => 'entry',
            	    'action' => 'index',
            	    'classes' =>$class['ID']),null,true) 
                . ' ">' . 
               $class['title'] . '</a>';
        }
    	return $links;
    }
    /**
     * Sets the view field 
     * @param $view Zend_View_Interface
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }
}
