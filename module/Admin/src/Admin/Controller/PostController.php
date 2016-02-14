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
use Admin\Form\PostForm;
use Admin\Entity\Post;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

class PostController extends AbstractActionController
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
    	$post = $this->getEntityManager()->getRepository('Admin\Entity\Post')->findAll();
        
        return new ViewModel(array('post' => $post));
    }

     public function addAction()
    {
        $form = new PostForm();
        $form->get('submit')->setAttribute('label', 'Add');
        //Initialise la liste des categories
        $categories = $this->getEntityManager()->getRepository('Admin\Entity\Categorie')->findAll();
        $options = array(""=>"");
        foreach($categories as $cat) {
            $options[$cat->id] = $cat->nom;
        }
        $form->setCategorie($options);
        $request = $this->getRequest();
        //Vérifie le type de la requête
        if ($request->isPost()) {
            $post = new Post();
            //Initialisation du formulaire à partir des données reçues
            $form->setData($request->getPost());
            //Ajout des filtres de validation basés sur l'objet Page
            $form->setInputFilter($post->getInputFilter());
            //Contrôle les champs
            if ($form->isValid()) {
                $post->exchangeArray($form->getData(FormInterface::VALUES_AS_ARRAY));
                $categorieId = $form->get('categorie_id')->getValue();
                $form->bindValues();
                $categorie = null;
                if (!empty($categorieId)) {
                    $categorie = $this->getEntityManager()->find('Admin\Entity\Categorie', $categorieId);
                }
                $post->setCategorie($categorie);
                $this->getEntityManager()->persist($post);
                $this->getEntityManager()->flush();
                //Redirection vers la liste des pages
                return $this->redirect()->toRoute('post');
            }
        }
        return array('form' => $form);
    }
    
    public function editAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        //Si l'Id est vie on redirige vers l'ajout
        if (!$id) {
            return $this->redirect()->toRoute('post', array('action'=>'add'));
        }
        //Sinon on charge le post correspondant à l'Id
        $post = $this->getEntityManager()->find('Admin\Entity\Post', $id);
        $form = new PostForm();
        //Initialise la liste des categories
        $categories = $this->getEntityManager()->getRepository('Admin\Entity\Categorie')->findAll();
        $options = array(""=>"");
        foreach($categories as $cat) {
            $options[$cat->id] = $cat->nom;
        }
        $form->setCategorie($options);
        //On charge ces données dans le formulaire initialise aussi les InputFilter
        $form->setBindOnValidate(false);
        $form->bind($post);
        $form->get('categorie_id')->setValue($post->getCategorie() != null ? $post->getCategorie()->getId() : '');
        $form->get('submit')->setAttribute('label', 'Edit');
        $request = $this->getRequest();
        //Vérifie le type de la requête
        if ($request->isPost()) {
            $form->setData($request->getPost());
            //Contrôle les champs
            if ($form->isValid()) {
                $categorieId = $form->get('categorie_id')->getValue();
                $form->bindValues();
                $categorie = null;
                if (!empty($categorieId)) {
                    $categorie = $this->getEntityManager()->find('Admin\Entity\Categorie', $categorieId);
                }
                $post->setCategorie($categorie);
                $this->getEntityManager()->flush();
                //Redirection vers la liste des post
                return $this->redirect()->toRoute('post');
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
        );
    }
    
    public function deleteAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('post');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Non');
            if ($del == 'Oui') {
                $id = (int)$request->getPost('id');
                $post = $this->getEntityManager()->find('Admin\Entity\Post', $id);
                if ($post) {
                    $this->getEntityManager()->remove($post);
                    $this->getEntityManager()->flush();
                }
            }
            //Redirection vers la liste des postes
            return $this->redirect()->toRoute('post');
        }
        return array(
            'id' => $id,
            'post' => $this->getEntityManager()->find('Admin\Entity\Post', $id)
        );
    }
    public function viewAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        //Si l'Id est vie on redirige vers la liste
        if (!$id) {
            return $this->redirect()->toRoute('post');
        }
        try{
            //Sinon on charge le post correspondant à l'Id
            $post = $this->getEntityManager()->find('Admin\Entity\Post', $id);
        }
        catch(\Exception $e){
                //Si la post n'existe pas en base on génère une erreur 404
                $response   = $this->response;
                $event    = $this->getEvent();
                $routeMatch = $event->getRouteMatch();
                $response->setStatusCode(404);
                $event->setParam('exception', new \Exception('Post Inconnue'.$id));
                $event->setController('post');
                return ;
        }
        return new ViewModel(array(
            'post' => $post
        ));
    }

}
