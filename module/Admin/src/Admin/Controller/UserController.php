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
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            $em = $this->getEntityManager();
            $users = $em->getRepository('Admin\Entity\User')->findBy(array(), array('username' => 'ASC'));
            
            $layout = $this->layout();
            $layout->setTemplate('layout/admin');
        }
        else{
            return $this->redirect()->toRoute('home');
        }
        return new ViewModel(array('users' => $users,));
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