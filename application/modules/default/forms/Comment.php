<?php
/** 
 * @author Florian Schuhmann
 * 
 * 
 */
class Default_Form_Comment extends Zend_Form
{
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
    
    public $elementDeco = array(
        'ViewHelper', 'Errors', 
    array(
        'Label', array(
        'class' => 'overlabel')));
    
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
       
	public function init(){
		$this->setMethod('post');
	    $this->setAttrib('class', 'comments');
        $this->setDecorators(
        array(
            'FormElements', 
        array(
            'HtmlTag', array(
            'tag' => 'div')), 'Form'));
        		
        $this->addElement(
            'textarea', 'comment', array(
                'label' => 'Kommentar',
                'required' => true,
        		'decorators' => $this->elementDeco,
            ));

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
        
        
        $this->submit->removeDecorator('label');
        $this->csrf->removeDecorator('label');
	}
}
?>