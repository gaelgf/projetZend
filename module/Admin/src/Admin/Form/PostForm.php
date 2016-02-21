<?php
namespace Admin\Form;
use Doctrine\ORM\EntityManager;
use Zend\Form\Form;
class PostForm extends Form
{
    public function __construct(EntityManager $em)
    {
        parent::__construct('post');
        $this->setAttribute('method', 'post');
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
        $this->add(array(
            'name' => 'categorie',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Categorie',
                'object_manager' => $em,
                'target_class' => 'Admin\Entity\Categorie',
                'property' => 'nom'
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Enregistrer',
                'id' => 'submitbutton',
            ),
        ));
    }
}