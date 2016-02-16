<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

use Stdlib\Model\Registry;
use Admin\Entity\Post;
use Admin\Form\PostForm;

class PostController extends AbstractActionController
{

    /**
   * @var EntityManager
   */
  protected $entityManager;

  /**
   * Sets the EntityManager
   *
   * @param EntityManager $em
   * @access protected
   * @return PostController
   */
  protected function setEntityManager(EntityManager $em)
  {
    $this->entityManager = $em;
    return $this;
  }

  /**
   * Returns the EntityManager
   *
   * Fetches the EntityManager from ServiceLocator if it has not been initiated
   * and then returns it
   *
   * @access protected
   * @return EntityManager
   */
  protected function getEntityManager()
  {
    if (null === $this->entityManager) {
      $this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
    }
    return $this->entityManager;
  }

    public function indexAction()
    {
    	$posts = $this->getEntityManager()->getRepository('Admin\Entity\Post')->findAll();
        
        $layout = $this->layout();
        $layout->setTemplate('layout/admin');
        
        return new ViewModel(array('posts' => $posts));
    }

     public function addAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        // Create the form and inject the ObjectManager
        $form = new PostForm($objectManager);

        // Create a new, empty entity and bind it to the form
        $post = new Post();
        $form->bind($post);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $objectManager->persist($post);
                $objectManager->flush();
            }
        }

        return array('form' => $form);
    }
    

    public function editAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        // Create the form and inject the ObjectManager
        $form = new PostForm($objectManager);

        // Create a new, empty entity and bind it to the form
        $post = $this->userService->get($this->params('post_id'));
        $form->bind($post);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                // Save the changes
                $objectManager->flush();
            }
        }

        return array('form' => $form);
    }
    
    public function deleteAction()
    {
        
    }
   

}
