<?php
/**
 * This ist the comment form.
 * 
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage Forms
 */
class Default_Form_Comment extends Zend_Form
{
    /**
     *  @var array create decorator config for the button
     */
    public $buttonDeco = array(
        'ViewHelper', 'Errors', 
    array(
        array(
        'data' => 'HtmlTag'), 
    array(
        'tag' => 'div', 'class' => 'commentsButton')), 
    array(
        'Label', array(
        'tag' => 'div')));
    /**
     * @var array create decorator config for the elements
     */
    public $elementDeco = array(
        'ViewHelper', 'Errors', 
    array(
        'Label', array(
        'class' => 'overlabel')));
    /**
     * @var array create decorator config for the hidden elements 
     */
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
    /**
     * initialize the form
     * @see Zend_Form::init()
     */
    public function init(){
        // set the submit method to POST
		$this->setMethod('post');
		// set action url
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() .'/entry/process/');
	    // set the form css class to login
		$this->setAttrib('class', 'comments');
		// set the form decorator
        $this->setDecorators(
        array(
            'FormElements', 
        array(
            'HtmlTag', array(
            'tag' => 'div')), 'Form'));
        // add input for the comment content
        $this->addElement(
            'textarea', 'content', array(
                'label' => 'Kommentar',
                'required' => true,
        		'decorators' => $this->elementDeco,
            ));
        // add submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'posten!',
        	'class' => 'button',
        	'decorators' => $this->buttonDeco
            ));
        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true, 'decorators' => $this->hiddenDeco
        ));
        
        // remove the label from the button        
        $this->submit->removeDecorator('label');
        // remove the label from the hidden CSRF field
        $this->csrf->removeDecorator('label');
	}
}
?>