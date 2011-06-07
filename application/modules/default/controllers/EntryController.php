<?php
/**
 * This ist the Controller for reading news and writing comments.
 * 
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage Controllers
 */
class EntryController extends Zend_Controller_Action
{
    /**
     * Shows a list of news. These can be filtered by owner or class.
     * 
     * @uses Default_Model_Entry
     */
    public function indexAction ()
    {
        $entry = new Default_Model_Entry();
        // get the filter params
        $request = $this->getRequest();
        $filterParams = array();
        if(null !== $owner = $request->getParam('owner')){
            $filterParams['owner'] = $owner;
        }
        if(null !== $class = $request->getParam('degreeClass')){
            $filterParams['degreeClass'] = $class;
        }
        // check if their are news found
        if(count($this->view->entries = $entry->fetchAll($filterParams)) == 0){
            $this->_redirect('error/notFound');
        }
    }
    /**
     * 
     * Shows a single news and their comments.
     * 
     * @uses Default_Model_Entry
     * @uses Zend_Auth
     * @uses Default_Form_Comment
     */
    public function showAction ()
    {
        $request = $this->getRequest();
        $news_id = $request->getParam('news_id');
        
        // find the news by news_id
        $entry = new Default_Model_Entry();
        $this->view->entry = $entry->find($news_id);
        // check if their is a news found
        if($this->view->entry->getNews_id() == null){
            $this->_redirect('error/notFound');
        }

        // check if the user is logged in
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity() && is_object($auth->getIdentity())) {
            $role = Application_Plugin_Auth_Roles::STUDENT;
        } else {
            $role = Application_Plugin_Auth_Roles::GUEST;
        }
        // check if the user could send comments
        $acl = new Application_Plugin_Auth_Acl();
        if ($acl->isAllowed($role, 'entry', 'process')) {
            // set this news_id as last viewed new in the session
            $auth->getIdentity()->setLastEntry($news_id);
            
            // Assign the comment form to the view
            $form = new Default_Form_Comment();
            $this->view->form = $form;
        }
    }
    /**
     * 
     * This function validates and processes the submited comment form.
     * 
     * @uses Zend_Auth
     * @uses Default_Form_Comment
     * @uses Default_Model_Comment
     */
    public function processAction ()
    {
        $request = $this->getRequest();
        // Check to see if this action has been POST'ed to.
        if ($request->isPost()) {
            $form = new Default_Form_Comment();
            // Now check to see if the form submitted exists, and
            // if the values passed in are valid for this form.
            if ($form->isValid($request->getPost())) {
                // Since we now know the form validated, we can now
                // start integrating that data sumitted via the form
                // into our model:
                $values = $form->getValues();
                
                // Now we need some extra informations from the session
                $auth = Zend_Auth::getInstance();
                // Check if we are in development and therefore the DB is used.
                // For the database use we need the following additional field.  
                $owner = new Default_Model_Owner();
                
                if(APPLICATION_ENV == 'development')
                    $owner->setDisplayedName($auth->getIdentity()->getFhs_id());
                
                $owner->setFhs_id($auth->getIdentity()->getFhs_id());
                $values['owner'] = $owner;
                $values['news_id'] = $auth->getIdentity()->getLastEntry();


                // creating a Default_Model_Comment with the subitted and 
                //checked values and save it.
                $model = new Default_Model_Comment($values);
                $model->save();
                 // Now that we have saved our model, lets url redirect
                 // to a new location.
                return $this->_helper->redirector->gotoSimple(
                'show', 'entry', null, array('news_id' => $values['news_id']));
            }
        }
        // If this action hasn't been POST'ed to we must url redirect.
        return $this->_helper->redirector->gotoSimple('index', 'entry');
    }
    /**
     * Here we delete comments.
     * 
     * @uses Default_Model_Comment
     */
    public function deleteAction(){
        $request = $this->getRequest();
        $id = $request->getParam('comment_id');
        
        // check if the user is logged in
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            // get the last viewed entry of this user
            $lastEntry=$auth->getIdentity()->getLastEntry();
            
            $model = new Default_Model_Comment();
            // get the owner of the comment
            $cruser=$model->find($id)->getOwner();
            
            // check if the user is the owner of the comment
            if($auth->getIdentity()->getFhs_id() == $cruser->getFhs_id()){
                // delete the comment
                $model->delete($id);
            }
            // redirect the user to his last viewed entry
            return $this->_helper->redirector->gotoSimple(
                'show', 'entry', null, array('news_id' => $lastEntry));            
        }
        // redirect to the index action
        return $this->_helper->redirector->gotoSimple('index', 'entry');        
    }
}