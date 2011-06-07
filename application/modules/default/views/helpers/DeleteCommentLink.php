<?php
/**
 * deleteCommentLink helper
 * 
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage viewHelper
 * @uses viewHelper Zend_View_Helper
 *  
 */
class Zend_View_Helper_DeleteCommentLink
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
	/**
	 * @param string $cruser
	 * @param int $commentId
	 */
    public function deleteCommentLink ($cruser,$comment_id)
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity() && $auth->getIdentity()->getFhs_id() == $cruser->getFhs_id())
            return '<a href="' . $this->view->url(array('controller' => 'entry', 'action' => 'delete','comment_id' => $this->view->escape($comment_id))) . '">[Eintrag löschen]</a>';
        return "";
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
