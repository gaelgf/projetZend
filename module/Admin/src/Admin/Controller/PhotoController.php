<?php
namespace Admin\Controller;

use Application\Controller\EntityUsingController;
use Zend\View\Model\ViewModel;
use Admin\Form\PhotoForm;
use Admin\Entity\Photo;

class PhotoController extends EntityUsingController
{
    /**
    *
    *
    */
    public function indexAction()
    {
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            $em = $this->getEntityManager();
            $photos = $em->getRepository('Admin\Entity\Photo')->findBy(array(), array('alt' => 'ASC'));
            
            $layout = $this->layout();
            $layout->setTemplate('layout/admin');
            return new ViewModel(array('photos' => $photos,));
        }else{
            return $this->redirect()->toRoute('home');
        }
    }
    public function editAction()
    {
        $photo = new Photo;
        if ($this->params('id') > 0) {
            $photo = $this->getEntityManager()->getRepository('Admin\Entity\Photo')->find($this->params('id'));
        }
        $form = new PhotoForm();
        $form->bind($photo);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($photo->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $em = $this->getEntityManager();
                $em->persist($photo);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('photo Enregistré');
                return $this->redirect()->toRoute('photo');
            }
        }
        $layout = $this->layout();
        $layout->setTemplate('layout/admin');
        return new ViewModel(array(
            'photo' => $photo,
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
        $photo = $this->getEntityManager()->getRepository('Admin\Entity\Photo')->find($this->params('id'));
        if ($photo) {
            $em = $this->getEntityManager();
            $em->remove($photo);
            $em->flush();
            $this->flashMessenger()->addSuccessMessage('Photo supprimé');
        }
        return $this->redirect()->toRoute('photo');
    }
}