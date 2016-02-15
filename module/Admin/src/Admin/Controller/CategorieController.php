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
use Zend\Form\FormInterface;
use Admin\Form\CategorieForm;
use Admin\Entity\Categorie;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

class CategorieController extends AbstractActionController
{

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction()
    {
    	$categorie = $this->getEntityManager()->getRepository('Admin\Entity\Categorie')->findAll();
        $layout = $this->layout();
        $layout->setTemplate('layout/admin');
        
        return new ViewModel(array('categorie' => $categorie));
    }

    public function addAction()
    {
        $form = new CategorieForm();
        $form->get('submit')->setAttribute('label', 'Add');
        $request = $this->getRequest();
        //Vérifie le type de la requête
        if ($request->isPost()) {
            $categorie = new Categorie();
            //Initialisation du formulaire à partir des données reçues
            $form->setData($request->getPost());
            //Ajout des filtres de validation basés sur l'objet categorie
            $form->setInputFilter($categorie->getInputFilter());
            //Contrôle les champs
            if ($form->isValid()) {
                $categorie->exchangeArray($form->getData(FormInterface::VALUES_AS_ARRAY));
                $form->bindValues();
                $this->getEntityManager()->persist($categorie);
                $this->getEntityManager()->flush();
                //Redirection vers la liste des Categories
                return $this->redirect()->toRoute('categorie');
            }
        }
        return array('form' => $form);
    }
    
    public function deleteAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('categorie');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Non');
            if ($del == 'Oui') {
                $id = (int)$request->getPost('id');
                $categorie = $this->getEntityManager()->find('Admin\Entity\Categorie', $id);
                if ($categorie) {
                    $this->getEntityManager()->remove($categorie);
                    $this->getEntityManager()->flush();
                }
            }
            //Redirection vers la liste des Categories
            return $this->redirect()->toRoute('categorie');
        }
        return array(
            'id' => $id,
            'categorie' => $this->getEntityManager()->find('Admin\Entity\Categorie', $id)
        );
    }


}
