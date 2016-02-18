<?php
namespace Admin\Controller;

use Application\Controller\EntityUsingController;
use Zend\View\Model\ViewModel;
use Admin\Form\CategorieForm;
use Admin\Entity\Categorie;

class CategorieController extends EntityUsingController
{
    /**
    *
    *
    */
    public function indexAction()
    {
        $em = $this->getEntityManager();
        $categories = $em->getRepository('Admin\Entity\Categorie')->findBy(array(), array('nom' => 'ASC'));
        
        $layout = $this->layout();
        $layout->setTemplate('layout/admin');
        return new ViewModel(array('categories' => $categories,));
    }
    public function editAction()
    {
        $categorie = new Categorie;
        if ($this->params('id') > 0) {
            $categorie = $this->getEntityManager()->getRepository('Admin\Entity\Categorie')->find($this->params('id'));
        }
        $form = new CategorieForm();
        $form->bind($categorie);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($categorie->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $em = $this->getEntityManager();
                $em->persist($categorie);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Categorie Enregistré');
                return $this->redirect()->toRoute('categorie');
            }
        }
        $layout = $this->layout();
        $layout->setTemplate('layout/admin');
        return new ViewModel(array(
            'categorie' => $categorie,
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
        $categorie = $this->getEntityManager()->getRepository('Admin\Entity\Categorie')->find($this->params('id'));
        if ($categorie) {
            $em = $this->getEntityManager();
            $em->remove($categorie);
            $em->flush();
            $this->flashMessenger()->addSuccessMessage('Categorie supprimé');
        }
        return $this->redirect()->toRoute('categorie');
    }
}