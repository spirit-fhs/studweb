<?php
/**
 * LoginController
 * 
 * @author Florian Schuhmann
 */
class LoginController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if (! $data) {
            $this->_redirect('login/login');
        }
        $this->view->username = $data->username;
        
    }
    public function loginAction ()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            return $this->_redirect('login/index');
        }
        $form = new Default_Form_Login_Login();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $data = $form->getValues();
                $username = $data['username'];
                $password = $data['password'];

                $users = new Default_Model_DbTable_Users();
                $authAdapter = new Zend_Auth_Adapter_DbTable($users->getAdapter(),'users');
		        $authAdapter->setIdentityColumn('username');
        		$authAdapter->setCredentialColumn('password');
                
                $authAdapter->setIdentity($username);
                $authAdapter->setCredential($password);
                $result = $auth->authenticate($authAdapter);
                if (! $result->isValid()) {
                    $messages = $result->getMessages();
                    $view->message = $messages[0];
                } else {
                    $storage = $auth->getStorage();
                    // die gesamte Tabellenzeile in der Session speichern,
                    // wobei das Passwort unterdrückt wird
                    $storage->write(
                    $authAdapter->getResultRowObject(null, 'password'));
                    $this->_redirect('login/index');
                }
            }
        }
    }
    public function logoutAction ()
    {
        Zend_Auth::getInstance()->clearIdentity();
        //clear the session
        Zend_Session::destroy();
        $this->_redirect('login/login');
    }
}