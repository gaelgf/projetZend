<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Application\Controller\EntityUsingController;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use Zend\View\Model\ViewModel;

use Admin\Entity\Post;
use Admin\Form\PostForm;

class PostController extends EntityUsingController
{
    /**
    * Index action
    *
    */
    public function indexAction()
    {
        $em = $this->getEntityManager();
        $posts = $em->getRepository('Admin\Entity\Post')->findBy(array(), array('titre' => 'ASC'));
        
        $layout = $this->layout();
        $layout->setTemplate('layout/admin');
        return new ViewModel(array('posts' => $posts,));
    }
    /**
    * Edit action
    *
    */
    public function editAction()
    {
        $post = new Post;

        if ($this->params('id') > 0) {
            $post = $this->getEntityManager()->getRepository('Admin\Entity\Post')->find($this->params('id'));
        }
        $form = new PostForm($this->getEntityManager());
        $form->setHydrator(new DoctrineEntity($this->getEntityManager(),'Admin\Entity\Post'));
        $form->bind($post);
        
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setInputFilter($post->getInputFilter());
            $form->setData($data);
            
            /*récupération de la catégorie*/
            $cat = $data->get('categorie');
            $categorie = $this->getEntityManager()->getRepository('Admin\Entity\Categorie')->find($cat);
            
            $post->setTitre($data->get('titre'));
            $post->setContenu($data->get('contenu'));
            $post->setCategorie($categorie);
            
            //if ($form->isValid()) {
                $em = $this->getEntityManager();
                //$em->persist($post);
                
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Post enregistré');
                return $this->redirect()->toRoute('post');
            //}
        }
        $layout = $this->layout();
        $layout->setTemplate('layout/admin');
        return new ViewModel(array(
            'post' => $post,
            'form' => $form
        ));
    }
    /**
    * Add action
    *
    */
    public function addAction()
    {
        $layout = $this->layout();
        $layout->setTemplate('layout/admin');
        return $this->editAction();
    }
    /**
    * Delete action
    *
    */
    public function deleteAction()
    {
        $post = $this->getEntityManager()->getRepository('Admin\Entity\Post')->find($this->params('id'));
        if ($post) {
            $em = $this->getEntityManager();
            $em->remove($post);
            $em->flush();
            $this->flashMessenger()->addSuccessMessage('Post Supprimé');
        }
        
        return $this->redirect()->toRoute('post');
    }
}