<?php
namespace Admin\Controller;

use Application\Controller\EntityUsingController;
use Zend\View\Model\ViewModel;
use Admin\Form\UserForm;
use Admin\Entity\User;

class UserController extends EntityUsingController
{
    /**
    *
    *
    */
    public function indexAction()
    {
        $em = $this->getEntityManager();
        $users = $em->getRepository('Admin\Entity\User')->findBy(array(), array('username' => 'ASC'));
        
        $layout = $this->layout();
        $layout->setTemplate('layout/admin');
        return new ViewModel(array('users' => $users,));
    }
    public function editAction()
    {
        $user = new User;
        if ($this->params('id') > 0) {
            $user = $this->getEntityManager()->getRepository('Admin\Entity\User')->find($this->params('id'));
        }
        $form = new UserForm();
        $form->bind($user);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($user->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $em = $this->getEntityManager();
                $em->persist($user);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('user Enregistré');
                return $this->redirect()->toRoute('user');
            }
        }
        $layout = $this->layout();
        $layout->setTemplate('layout/admin');
        return new ViewModel(array(
            'user' => $user,
            'form' => $form
        ));
    }
    public function addAction()
    {
        $layout = $this->layout();
        $layout->setTemplate('layout/admin');
        return $this->editAction();
    }
    public function deleteAction()
    {
        $user = $this->getEntityManager()->getRepository('Admin\Entity\User')->find($this->params('id'));
        if ($user) {
            $em = $this->getEntityManager();
            $em->remove($user);
            $em->flush();
            $this->flashMessenger()->addSuccessMessage('user supprimé');
        }
        return $this->redirect()->toRoute('user');
    }
}