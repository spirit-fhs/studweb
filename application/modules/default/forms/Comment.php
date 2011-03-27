<?php
/** 
 * @author Florian Schuhmann
 * 
 * 
 */
class Default_Form_Comment extends Zend_Form
{
	public function init(){
		$this->setMethod('post');
        $this->addElement(
            'textarea', 'text', array(
                'label' => 'Kommentar',
                'required' => true,
        		'rows' => '5',
        		'cols' => '45'
            ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'posten',
            ));
        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
        
        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));        
	}
}
?>