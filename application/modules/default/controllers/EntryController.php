<?php
class EntryController extends Zend_Controller_Action
{
    public function init ()
    {
        /* Initialize action controller here */
    }
    public function indexAction ()
    {
        $entry = new Default_Model_Entry();
                
        $request = $this->getRequest();
        $filterParams = array();
        if(null !== $owner = $request->getParam('owner')){
            $filterParams['owner'] = $owner;
        }
        if(null !== $classes = $request->getParam('classes')){
            $filterParams['classes'] = $classes;
        }
        
        if(count($this->view->entries = $entry->fetchAll($filterParams)) == 0){
            $this->_redirect('error/notFound');
        }
    }
    public function showAction ()
    {
        $request = $this->getRequest();
        $news_id = $request->getParam('news_id');

        $entry = new Default_Model_Entry();
        $this->view->entry = $entry->find($news_id);
        // no news found
        if($this->view->entry->getNews_id() == null){
            $this->_redirect('error/notFound');
        }
            

        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity() && is_object($auth->getIdentity())) {
            $role = Application_Plugin_Auth_Roles::STUDENT;
        } else {
            $role = Application_Plugin_Auth_Roles::GUEST;
        }
        $acl = new Application_Plugin_Auth_Acl();
        if ($acl->isAllowed($role, 'entry', 'process')) {
            $auth->getIdentity()->setLastEntry($news_id);
            
            $form = new Default_Form_Comment();
            // Assign the form to the view
            $this->view->form = $form;
        }
    }
    public function processAction ()
    {
        $request = $this->getRequest();
        $auth = Zend_Auth::getInstance();
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
                $values['owner'] = $auth->getIdentity()->getUid();
                $values['entryId'] = $auth->getIdentity()->getLastEntry();
                
                if(APPLICATION_ENV == 'development')
                    $values['displayedName'] = $auth->getIdentity()->getUid();
                
                    $model = new Default_Model_Comment($values);
                $model->save();
                 // Now that we have saved our model, lets url redirect
                 // to a new location.
                return $this->_helper->redirector->gotoSimple(
                'show', 'entry', null, array('news_id' => $values['entryId']));
            }
        }
        return $this->_helper->redirector->gotoSimple('index', 'entry');
    }
    public function deleteAction(){
        $request = $this->getRequest();
        $id = $request->getParam('commentId');
        
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $lastEntry=$auth->getIdentity()->getLastEntry();
            $model = new Default_Model_Comment();
            $cruser=$model->find($id)->getOwner();
            if($auth->getIdentity()->getUid() == $cruser){
                $model->delete($id);
            }
            return $this->_helper->redirector->gotoSimple(
                'show', 'entry', null, array('news_id' => $lastEntry));            
        }
        return $this->_helper->redirector->gotoSimple('index', 'entry');        
    }
}

