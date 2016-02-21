<?php
namespace Admin\Form;

use Zend\Form\Form;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PostForm extends Form implements ObjectManagerAwareInterface
{
    protected $objectManager;

    public function init()
    {
        $this->add(array(
            'name' => 'titre',
            'type'  => 'text',
            'options' => array('label' => 'Titre'),
            'attributes' => array(
                'class' => 'input-xxlarge'
            )
        ));
        $this->add(array(
            'name' => 'contenu',
            'type'  => 'textarea',
            'options' => array('label' => 'Contenu',),
        ));
        $this->add(
            array(
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'categorie',
                'options' => array(
                    'object_manager' => $this->getObjectManager(),
                    'target_class'   => 'Admin\Entity\Categorie',
                    'property'       => 'nom',
                ),
            )
        );
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Enregistrer',
                'id' => 'submitbutton',
            ),
        ));
    }

    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function getObjectManager()
    {
        return $this->objectManager;
    }    
}