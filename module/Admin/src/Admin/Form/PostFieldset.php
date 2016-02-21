<?php 

namespace Admin\Form;

use Admin\Entity\Post;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Doctrine\Common\Persistence\ObjectManager as ObjectManager;


class PostFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $om)
    {
        parent::__construct('post');
        $this->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new Post());

        $this->add(array(
            'name' => 'titre',
            'options' => array(
                'label' => 'Titre'
            ),
            'attributes' => array(
                'required' => 'required'
            )
        ));

        $this->add(array(
            'name' => 'contenu',
            'options' => array(
                'label' => 'contenu'
            ),
            'attributes' => array(
                'required' => 'required'
            )
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'nom',
            'options' => array(
                'label' => 'Categorie',
                'object_manager' => $om,
                'target_class'   => 'Module\Entity\User',
                'property'       => 'nom',

            )
        ));

    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     \*/
    public function getInputFilterSpecification()
    {
        return array(
            'titre' => array(
                'required' => true,
            ),
            'contenu' => array(
                'required' => true,
            )
        );
    }
}