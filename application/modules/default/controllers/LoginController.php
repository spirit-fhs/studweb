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
        $this->_redirect('/');
    }
    public function loginAction ()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            return $this->_redirect('login/index');
        }
        $form = new Default_Form_Login();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $data = $form->getValues();
                $username = $data['username'];
                $password = $data['password'];
                if ('development' == APPLICATION_ENV) {
                    $users = new Default_Model_DbTable_Users();
                    $authAdapter = new Zend_Auth_Adapter_DbTable(
                    $users->getAdapter(), 'users');
                    $authAdapter->setIdentityColumn('username');
                    $authAdapter->setCredentialColumn('password');
                    $authAdapter->setIdentity($username);
                    $authAdapter->setCredential($password);
                    $result = $auth->authenticate($authAdapter);
                } else {
                    $config = new Zend_Config_Ini(
                    APPLICATION_PATH . '/configs/application.ini', 'production');
                    $log_path = $config->ldap->log_path;
                    $options = $config->ldap->toArray();
                    unset($options['log_path']);
                    $authAdapter = new Zend_Auth_Adapter_Ldap($options, 
                    $username, $password);
                    $result = $auth->authenticate($authAdapter);
                    if ($log_path) {
                        $messages = $result->getMessages();
                        $logger = new Zend_Log();
                        $logger->addWriter(
                        new Zend_Log_Writer_Stream($log_path));
                        $filter = new Zend_Log_Filter_Priority(Zend_Log::DEBUG);
                        $logger->addFilter($filter);
                        foreach ($messages as $i => $message) {
                            if ($i -- > 1) { // $messages[2] und h�her sind Log Nachrichten
                                $message = str_replace(
                                "\n", "\n  ", $message);
                                $logger->log("Ldap: $i: $message", 
                                Zend_Log::DEBUG);
                            }
                        }
                    }
                }
                if (! $result->isValid()) {
                    $messages = $result->getMessages();
                    $view->message = $messages[0];
                } else {
                    $storage = $auth->getStorage();
					
					$user = new Default_Model_User();
					
                    // die gesamte Tabellenzeile in der Session speichern,
                    // wobei das Passwort unterdrueckt wird
                    if ('development' == APPLICATION_ENV) { //DB
                        $temp = $authAdapter->getResultRowObject(null, 'password');

                        $user->setUid($temp->id)
                        ->setTitle("")
                        ->setMail("novalide@mail")
                        ->setLastName($temp->username)
                        ->setFirstName($temp->username)
                        ->setFaculty("Informatik")
                        ->setCourse("Testcourse")
                        ->setCn($temp->username);
                        
                    } else { //LDAP
                        $temp = $authAdapter->getAccountObject(array('cn', 'givenname', 'mail','uid', 'personaltitle', 'sn', 'stg', 'ou'));
                        
                        $user->setUid($temp->uid)
                        ->setTitle($temp->personaltitle)
                        ->setMail($temp->mail)
                        ->setLastName($temp->sn)
                        ->setFirstName($temp->givenname)
                        ->setFaculty($temp->ou)
                        ->setCourse($temp->stg)
                        ->setCn($temp->cn);

                    }
					$storage->write($user);
                    $this->_redirect('/');
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