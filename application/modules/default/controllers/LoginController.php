<?php
/**
 * This controller is responsible for authentication.
 * 
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage Controllers
 */
class LoginController extends Zend_Controller_Action
{
    /**
     * 
     * The default action - shows the home page
     */
    public function indexAction ()
    {
        $this->_redirect('/');
    }
    /**
     * 
     * authenticates the user against LDAP / DB
     * 
     * @uses Zend_Auth
     * @uses Default_Form_Login
     * @uses Default_Model_DbTable_Users
     * @uses Zend_Auth_Adapter_DbTable
     * @uses Zend_Config_Ini
     * @uses Zend_Auth_Adapter_Ldap
     * @uses Zend_Log
     * @uses Zend_Log_Writer_Stream
     * @uses Zend_Log_Filter_Priority
     * @uses Default_Model_User
     */
    public function loginAction ()
    {
        // check if the user is logged in
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            return $this->_redirect('login/index');
        }
        
        $form = new Default_Form_Login();
        // check if their is an POST request
        if ($this->getRequest()->isPost()) {
            // check if the submitted values are valid
            if ($form->isValid($_POST)) {
                $data = $form->getValues();
                $username = $data['username'];
                $password = $data['password'];

                // switch between DB and LDAP authentication
                if ('development' == APPLICATION_ENV) {
                    // create a Default_Model_DbTable_Users
                    $users = new Default_Model_DbTable_Users();
                    
                    // set up an auth adapter for DB
                    $authAdapter = new Zend_Auth_Adapter_DbTable(
                        $users->getAdapter(), 'users');
                    $authAdapter->setIdentityColumn('username');
                    $authAdapter->setCredentialColumn('password');
                    $authAdapter->setIdentity($username);
                    $authAdapter->setCredential($password);
                    // authenticate the user
                    $result = $auth->authenticate($authAdapter);
                } else {
                    // get the config
                    $config = new Zend_Config_Ini(
                        APPLICATION_PATH . '/configs/application.ini', 'production');
                    // get LDAP connection info and log_path
                    $log_path = $config->ldap->log_path;
                    $options = $config->ldap->toArray();
                    unset($options['log_path']);
                    // set up an auth adapter for LDAP
                    $authAdapter = new Zend_Auth_Adapter_Ldap($options, 
                        $username, $password);
                    // authenticate the user
                    $result = $auth->authenticate($authAdapter);
                    // check if log_path is set
                    if ($log_path) {
                        // get the LDAP messages
                        $messages = $result->getMessages();
                        // set up a Zend_Log and Filter
                        $logger = new Zend_Log();
                        $logger->addWriter(
                            new Zend_Log_Writer_Stream($log_path));
                        $filter = new Zend_Log_Filter_Priority(Zend_Log::DEBUG);
                        $logger->addFilter($filter);
                        // log all messages
                        foreach ($messages as $i => $message) {
                            if ($i -- > 1) { // $messages[2] and higher are log messages
                                $message = str_replace(
                                	"\n", "\n  ", $message);
                                $logger->log("Ldap: $i: $message", 
                                    Zend_Log::DEBUG);
                            }
                        }
                    }
                }
                // check the authentication result
                if (!$result->isValid()) {
                    // Needed for debugging
                    //$messages = $result->getMessages();
                    
                    // User gets this message if:
                    //     username and password did not match or
                    //     username is not found
                    
                    $form->setDescription('Invalid credentials provided');
                } else {
                    // starting a Zend_Auth session
                    $storage = $auth->getStorage();
					
					$user = new Default_Model_User();
					
                    // save all data except the password to the session
                    if ('development' == APPLICATION_ENV) { //DB
                        $temp = $authAdapter->getResultRowObject(null, 'password');

                        $user->setFhs_id($temp->id)
                        ->setTitle("")
                        ->setMail("novalide@mail")
                        ->setLastName($temp->username)
                        ->setFirstName($temp->username)
                        ->setFaculty("Informatik")
                        ->setCourse("Testcourse")
                        ->setCn($temp->username);
                        
                    } else { //LDAP
                        $temp = $authAdapter->getAccountObject(array('cn', 'givenname', 'mail','uid', 'personaltitle', 'sn', 'stg', 'ou'));
                        
                        $user->setFhs_id($temp->uid)
                        ->setTitle($temp->personaltitle)
                        ->setMail($temp->mail)
                        ->setLastName($temp->sn)
                        ->setFirstName($temp->givenname)
                        ->setFaculty($temp->ou)
                        ->setCourse($temp->stg)
                        ->setCn($temp->cn);

                    }
                    // write the Default_Model_User to the session
					$storage->write($user);
                    $this->_redirect('/');
                }
            }
        }
        $this->view->form = $form;
    }
    /**
     * Logs the user out.
     * 
     * @uses Zend_Auth
     * @uses Zend_Session
     */
    public function logoutAction ()
    {
        // clear the Zend_Auth Identity/ Session
        Zend_Auth::getInstance()->clearIdentity();
        // clear all sessions
        Zend_Session::destroy();
        // redirect to the login page
        $this->_redirect('login/login');
    }
}