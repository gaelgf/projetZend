<?php
namespace Admin\Form;
use Zend\Form\Form;
class CommentForm extends Form
{
    public function __construct()
    {
        parent::__construct('comment');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'contenu',
            'type'  => 'textarea',
            'options' => array('label' => 'Contenu',),
        ));
         $this->add(array(
             'type' => 'Zend\Form\Element\Email',
             'name' => 'email',
             'options' => array(
                 'label' => 'Email Address'
             ),
         ));
         
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
            ),
        ));
        //var_dump($this);exit();
    }
}