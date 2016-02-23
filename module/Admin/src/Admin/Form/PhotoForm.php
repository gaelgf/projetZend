<?php
namespace Admin\Form;
use Zend\Form\Form;
class PhotoForm extends Form
{
    public function __construct()
    {
        parent::__construct('photo');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'lien',
            'type'  => 'text',
            'options' => array('label' => 'Lien',),
        ));
        $this->add(array(
            'name' => 'alt',
            'type'  => 'text',
            'options' => array('label' => 'Alt',),
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