<?php
/**
 * This ist the login form.
 * 
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage Forms
 */
class Default_Form_Login extends Zend_Form
{
    /**
     * @var array create decorator config for the button
     */
    public $buttonDeco = array(
    	'ViewHelper', 'Errors', array(
            array('data' => 'HtmlTag'),
            array(
            	'tag' => 'div', 
            	'class' => 'loginButton')), 
        array('Label', array('tag' => 'div')), 
        array(
            array('row' => 'HtmlTag'), 
            array(
            	'tag' => 'div', 
            	'class' => 'loginContainer')
        ));
    /**
     * @var array create decorator config for the elements 
     */    
    public $elementDeco = array(
        'ViewHelper', 'Errors', array(
            array('data' => 'HtmlTag'),
            array(
            	'tag' => 'div', 
            	'class' => 'loginElement')),
        array('Label', array('tag' => 'div')),
        array(
            array('row' => 'HtmlTag'),
            array(
            	'tag' => 'div', 
            	'class' => 'loginContainer')
        ));
    /**
     * @var array create decorator config for the hidden elements
     */
    public $hiddenDeco = array(
        'ViewHelper', 'Errors', array(
        	'Label', array('tag' => 'div')),
        array(
            array('row' => 'HtmlTag'),
            array(
            	'tag' => 'div', 
            	'class' => 'clear')
        ));
    /**
     * initialize the form
     * @see Zend_Form::init()
     */
    public function init (){
        // set the submit method to POST
        $this->setMethod('post');
        // set the form css class to login
        $this->setAttrib('class', 'login');
        // set the form decorator
        $this->setDecorators(array(
            'FormElements', array(
                'HtmlTag', array('tag' => 'div')),
            array('Description',array(
            	'tag' => 'p', 
            	'class' => 'description')),
            'Form'));
        // add input for username
        $this->addElement('text', 'username', 
        array(
            'label' => 'Benutzername:', 
            'required' => true,
            'filters' => array('StringTrim'), 
            'decorators' => $this->elementDeco,
            'class' => 'login' ));
        // add input for password
        $this->addElement('password', 'password', 
        array(
            'label' => 'Passwort:', 'required' => true, 
        	'decorators' => $this->elementDeco,
            'class' => 'login'));
        // add submit button
        $this->addElement('submit', 'submit', 
        array(
            'ignore' => true,
            'class' => 'button',
            'label' => 'Anmelden',
        	'decorators' => $this->buttonDeco));
        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', 
        array(
            'ignore' => true, 'decorators' => $this->hiddenDeco));
        // remove the label from the button
        $this->submit->removeDecorator('label');
        // remove the label from the hidden CSRF field
        $this->csrf->removeDecorator('label');
    }
}
?>