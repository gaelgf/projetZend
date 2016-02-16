<?php
namespace Admin\Form;
 
use Admin\Entity\Post;
    
use Stdlib\Model\Registry;
 
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
 
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
 
 
class PostFieldset extends Fieldset implements InputFilterProviderInterface
{
  public function __construct(ObjectManager $objectManager)
  {
    parent::__construct('post');
 
    $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new Post());
 
    $this->add(array(
      'name' => 'id',
      'attributes' => array(
        'type' => 'hidden'
      )
    ));
 
    $this->add(array(
      'name' => 'titre',
      'options' => array(
        'label' => 'Titre de l\'article'
      ),
      'attributes' => array(
        'type' => 'text'
      )
    ));
 
    $this->add(array(
      'name' => 'contenu',
      'options' => array(
        'label' => 'Contenu de l\'article'
      ),
      'attributes' => array(
        'type' => 'textarea'
      )
    ));
  }
 
  /**
   * Define InputFilterSpecifications
   *
   * @access public
   * @return array
   */
  public function getInputFilterSpecification()
  {
    return array(
      'titre' => array(
        'required' => true,
        'filters' => array(
          array('name' => 'StringTrim'),
          array('name' => 'StripTags')
        ),
        'properties' => array(
          'required' => true
        )
      ),
      'contenu' => array(
        'required' => true,
        'filters' => array(
          array('name' => 'StringTrim'),
          array('name' => 'StripTags')
        ),
        'properties' => array(
          'required' => true
        )
      )
    );
  }
}