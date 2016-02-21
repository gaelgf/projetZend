<?php

namespace Admin\Form;

use Admin\Entity\Categorie;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class CategorieFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('categorie');
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Categorie());

        $this->add(array(
            'name' => 'nom',
            'options' => array(
                'label' => 'Catégorie'
            ),
            'attributes' => array(
                'required' => 'required'
            )
        ));

        
    }

    /**
     * @return array
     \*/
    public function getInputFilterSpecification()
    {
        return array(
            'nom' => array(
                'required' => true,
            )
        );
    }
}