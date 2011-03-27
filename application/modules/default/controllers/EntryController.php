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
        $id = $this->getRequest()->getParam('id');
        $entry = new Default_Model_Entry();
        $this->view->entry = $entry->find($id);
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity() && is_object($auth->getIdentity())) {
            $role = Application_Plugin_Auth_Roles::STUDENT;
        } else {
            $role = Application_Plugin_Auth_Roles::GUEST;
        }
        $acl = new Application_Plugin_Auth_Acl();
        if ($acl->isAllowed($role, 'entry', 'addComment')) {
            $request = $this->getRequest();
            $form = new Default_Form_Comment();
            $form->addElement('hidden', 'entryId', array('value' => $id));
            $form->addElement('hidden', 'cruser', 
            array('value' => $auth->getIdentity()
                ->getUid()));
            // Check to see if this action has been POST'ed to.
            if ($this->getRequest()->isPost()) {
                // Now check to see if the form submitted exists, and
                // if the values passed in are valid for this form.
                if ($form->isValid($request->getPost())) {
                    // Since we now know the form validated, we can now
                    // start integrating that data sumitted via the form
                    // into our model:
                    $model = new Default_Model_Comment(
                    $form->getValues());
                    $model->save();
                    // Now that we have saved our model, lets url redirect
                    // to a new location.
                    // This is also considered a "redirect after post";
                    // @see http://en.wikipedia.org/wiki/Post/Redirect/Get
                    return $this->_helper->redirector->gotoSimple(
                    'show', 'entry', null, array('id' => $id));
                }
            }
            // Assign the form to the view
            $this->view->form = $form;
        }
    }
}

