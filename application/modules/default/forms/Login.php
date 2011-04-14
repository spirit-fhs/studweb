<?php
/** 
 * @author Florian Schuhmann
 * 
 * 
 */
class Default_Form_Login extends Zend_Form
{
    public $buttonDeco = array(
        'ViewHelper', 'Errors', 
    array(
        array(
        'data' => 'HtmlTag'), 
    array(
        'tag' => 'div', 'class' => 'loginButton')), 
    array(
        'Label', array(
        'tag' => 'div')), 
    array(
        array(
        'row' => 'HtmlTag'), 
    array(
        'tag' => 'div', 'class' => 'loginContainer')));
    
    public $elementDeco = array(
        'ViewHelper', 'Errors', 
    array(
        array(
        'data' => 'HtmlTag'), 
    array(
        'tag' => 'div', 'class' => 'loginElement')), 
    array(
        'Label', array(
        'tag' => 'div')), 
    array(
        array(
        'row' => 'HtmlTag'), 
    array(
        'tag' => 'div', 'class' => 'loginContainer')));
    
    public $hiddenDeco = array(
        'ViewHelper', 'Errors', 
    array(
        'Label', array(
        'tag' => 'div')), 
    array(
        array(
        'row' => 'HtmlTag'), 
    array(
        'tag' => 'div', 'class' => 'clear')));
    
    public function init ()
    {
        $this->setMethod('post');
        $this->setAttrib('class', 'login');
        $this->setDecorators(
        array(
            'FormElements', 
        array(
            'HtmlTag', array(
            'tag' => 'div')), 'Form'));
        $this->addElement('text', 'username', 
        array(
            'label' => 'Benutzername:', 
            'required' => true,
            'filters' => array('StringTrim'), 
            'decorators' => $this->elementDeco,
            'class' => 'login' ));
        $this->addElement('password', 'password', 
        array(
            'label' => 'Passwort:', 'required' => true, 
        	'decorators' => $this->elementDeco,
            'class' => 'login'));

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
        
        $this->submit->removeDecorator('label');
        $this->csrf->removeDecorator('label');
    }
}
?>