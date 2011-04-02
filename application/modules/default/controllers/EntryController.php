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
        $this->view->entries = $entry->fetchAll();
    }
    public function showAction ()
    {
        $request = $this->getRequest();
        $id = $request->getParam('id');

        $entry = new Default_Model_Entry();
        $this->view->entry = $entry->find($id);

        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity() && is_object($auth->getIdentity())) {
            $role = Application_Plugin_Auth_Roles::STUDENT;
        } else {
            $role = Application_Plugin_Auth_Roles::GUEST;
        }
        $acl = new Application_Plugin_Auth_Acl();
        if ($acl->isAllowed($role, 'entry', 'process')) {
            $auth->getIdentity()->setLastEntry($id);
            
            $form = new Default_Form_Comment();
            $form->setAction('/entry/process/');
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
                $values['user'] = $auth->getIdentity()->getUid();
                $values['entryId'] = $auth->getIdentity()->getLastEntry();
                $model = new Default_Model_Comment($values);
                $model->save();
                 // Now that we have saved our model, lets url redirect
                 // to a new location.
                return $this->_helper->redirector->gotoSimple(
                'show', 'entry', null, array('id' => $values['entryId']));
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
            $cruser=$model->find($id)->getUser();
            if($auth->getIdentity()->getUid() == $cruser){
                $model->delete($id);
            }
            return $this->_helper->redirector->gotoSimple(
                'show', 'entry', null, array('id' => $lastEntry));            
        }
        return $this->_helper->redirector->gotoSimple('index', 'entry');        
    }
}

