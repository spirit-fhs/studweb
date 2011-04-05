<?php
/**
 *
 * @author Florian Schuhmann
 * @version 
 */
/**
 * deleteCommentLink helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_DeleteCommentLink
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    public function deleteCommentLink ($cruser,$commentId)
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity() && $auth->getIdentity()->getUid() == $cruser)
            return '<a href="' . $this->view->url(array('controller' => 'entry', 'action' => 'delete','commentId' => $this->view->escape($commentId))) . '">[Eintrag löschen]</a>';
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
