<?php
namespace Admin\Controller;

use Application\Controller\EntityUsingController;
use Zend\View\Model\ViewModel;
use Admin\Form\CommentForm;
use Admin\Entity\Comment;

class CommentController extends EntityUsingController
{
    /**
    *
    *
    */
    public function indexAction()
    {
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            $em = $this->getEntityManager();
            $comments = $em->getRepository('Admin\Entity\Comment')->findBy(array(), array('email' => 'ASC'));
            
            $layout = $this->layout();
            $layout->setTemplate('layout/admin');
            return new ViewModel(array('comments' => $comments,));
        }else{
            return $this->redirect()->toRoute('home');
        }
    }
    
    public function editAction($id)
    {

        $comment = $this->getEntityManager()->getRepository('Admin\Entity\Comment')->find($id);
        
        $form = new CommentForm();
        $form->bind($comment);
        $request = $this->getRequest();
    
        if ($request->isPost()) {
            
            $data = $request->getPost();
            
            $form->setInputFilter($comment->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $em = $this->getEntityManager();

                $em->persist($comment);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Commentaire Enregistré');
                return $this->redirect()->toRoute('blog');
            }
        }
        /*$layout = $this->layout();
        $layout->setTemplate('layout/admin');*/
        return new ViewModel(array(
            'comment' => $comment,
            'form' => $form
        ));
    }

    public function addAction($id = null)
    {

        $postId = $this->params()->fromRoute('id');

        $comment = new Comment;
        $form = new CommentForm();
        $form->bind($comment);
            
        if($postId != null){
            $post = $this->getEntityManager()->getRepository('Admin\Entity\Post')->find($postId);
            $comment->setPost($post);
            $this->getEntityManager()->persist($comment);
            $this->getEntityManager()->flush();

            return $this->editAction($comment->getId());
        }
        

        $request = $this->getRequest();
    
        if ($request->isPost()) {
            //var_dump($postId);exit();
            $data = $request->getPost();
            
            $form->setInputFilter($comment->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $em = $this->getEntityManager();

                $em->persist($comment);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Commentaire Enregistré');
                return $this->redirect()->toRoute('blog');
            }
        }

        /*$layout = $this->layout();
        $layout->setTemplate('layout/admin');*/
        return new ViewModel(array(
            'comment' => $comment,
            'form' => $form
        ));
    }
    public function deleteAction()
    {
        $comment = $this->getEntityManager()->getRepository('Admin\Entity\Comment')->find($this->params('id'));
        if ($comment) {
            $em = $this->getEntityManager();
            $em->remove($comment);
            $em->flush();
            $this->flashMessenger()->addSuccessMessage('Comment supprimé');
        }
        return $this->redirect()->toRoute('comment');
    }
}