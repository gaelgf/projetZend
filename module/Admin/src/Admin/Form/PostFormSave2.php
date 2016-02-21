<?php
namespace Admin\Form;
use Doctrine\ORM\EntityManager;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
class PostForm extends Form
{
    public function __construct(EntityManager $em)
    {
        parent::__construct('post');

        $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new InputFilter());

        $this->add(array(
            'type' => 'Admin\Form\PostFieldset',
            'options' => array(
                'use_as_base_fieldset' => true
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Enregistrer',
                'id' => 'submitbutton',
        )));
    }
}