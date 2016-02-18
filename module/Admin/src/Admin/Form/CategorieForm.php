<?php
namespace Admin\Form;
use Zend\Form\Form;
class CategorieForm extends Form
{
    public function __construct()
    {
        parent::__construct('categorie');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'nom',
            'type'  => 'text',
            'options' => array('label' => 'Nom',),
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