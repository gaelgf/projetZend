<?php
namespace Admin\Form;

use Zend\Form\Form;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class PostForm extends Form
{
  public function __construct(ObjectManager $objectManager)
  {
    parent::__construct('post');

   $this->setHydrator(new DoctrineHydrator($objectManager));

    $postFieldset = new PostFieldset($objectManager);
        $postFieldset->setUseAsBaseFieldset(true);
        $this->add($postFieldset);
  }
}